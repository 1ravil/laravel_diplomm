<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Categories;
use App\Models\create_orders_products_customers_table;
use App\Models\customers;
use App\Models\orders;
use App\Models\orders_products;
use App\Models\Products;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{

    public function index()
    {
        return view('index');
    }

    public function contacts()
    {
        return view('contacts');
    }

    public function garanty()
    {
        return view('garanty');
    }

    public function installment()
    {
        return view('installment');
    }
    public function catalog()
    {
        $categories = Categories::all();
        return view('categories', compact('categories'));
    }

    public function question()
    {
        return view('question');
    }

    public function catalog_accessory()
    {
        return view('catalog_accessory');
    }

    public function categories()
    {
        $categories = Categories::all();
        return view('categories', compact('categories'));
    }

    public function product_card()
    {
        return view('product_card');
    }

    public function categoriesByPhone($categoryId, Request $request) {
        if (!is_numeric($categoryId) || intval($categoryId) <= 0) {
            throw new NotFoundHttpException('Category not found');
        }

        try {
            $category = Categories::findOrFail($categoryId);
            $productsQuery = $category->products();

            // Фильтр по памяти
            if ($request->has('memory') && !empty($request->memory)) {
                $productsQuery->whereIn('product_memory', $request->memory);
            }

            // Фильтр по модели
            if ($request->has('model') && !empty($request->model)) {
                $productsQuery->whereIn('product_name', $request->model);
            }

            // Фильтр по цвету
            if ($request->has('color') && !empty($request->color)) {
                $productsQuery->whereIn('product_color', $request->color);
            }



            // Сортировка
            if ($request->has('sort')) {
                switch ($request->sort) {
                    case 'price-asc':
                        $productsQuery->orderBy('product_price', 'asc');
                        break;
                    case 'price-desc':
                        $productsQuery->orderBy('product_price', 'desc');
                        break;
                    case 'name-asc':
                        $productsQuery->orderBy('product_name', 'asc');
                        break;
                    case 'name-desc':
                        $productsQuery->orderBy('product_name', 'desc');
                        break;
                    default:
                        $productsQuery->orderBy('created_at', 'desc');
                        break;
                }
            } else {
                $productsQuery->orderBy('created_at', 'desc');
            }

            // Получаем отфильтрованные продукты
            $products = $productsQuery->get();

            // Получаем уникальные значения для фильтров с количеством товаров
            $uniqueModels = $category->products()
                ->select('product_name', DB::raw('count(*) as total'))
                ->whereNotNull('product_name') // Исключаем пустые значения
                ->where('product_name', '<>', '') // Исключаем пустые строки
                ->groupBy('product_name')
                ->pluck('total', 'product_name');

            $uniqueColors = $category->products()
                ->select('product_color', DB::raw('count(*) as total'))
                ->whereNotNull('product_color') // Исключаем пустые значения
                ->where('product_color', '<>', '') // Исключаем пустые строки
                ->groupBy('product_color')
                ->pluck('total', 'product_color');

            $uniqueMemory = $category->products()
                ->select('product_memory', DB::raw('count(*) as total'))
                ->whereNotNull('product_memory') // Исключаем пустые значения
                ->where('product_memory', '<>', '') // Исключаем пустые строки
                ->groupBy('product_memory')
                ->pluck('total', 'product_memory');

            return view('catalog', compact('products', 'category', 'uniqueModels', 'uniqueColors', 'uniqueMemory'));
        } catch (NotFoundHttpException $e) {
            abort(404, 'Category not found');
        }
    }

    public function adminPanel() {
        $categories = Categories::all();
        $products = Products::all();
        return view('adminPanel', compact('categories', 'products'));
    }

    public function adminPanelCategory() {

        $categoriess = Categories::all();
        $products = Products::all();
        return view('adminPanelCategory', compact('categoriess', 'products'));
    }


    public function adminPanelOrders() {
        $orders = DB::table('orders_products_customers')
            ->leftJoin('orders', 'orders_products_customers.order_id', '=', 'orders.id')
            ->leftJoin('customers', 'orders_products_customers.customer_id', '=', 'customers.id')
            ->leftJoin('orders_products', 'orders_products_customers.order_id', '=', 'orders_products.orders_id')
            ->leftJoin('products', 'orders_products.products_id', '=', 'products.id')
            ->select(
                'orders_products_customers.order_id',
                DB::raw("COALESCE(customers.customer_name, 'Неизвестный клиент') AS customer_name"),
                'customers.phone',
                'orders_products_customers.created_at',
                'orders_products_customers.terms',
                DB::raw("STRING_AGG(products.product_name, ', ') AS product_names"),
                DB::raw("SUM(orders_products.count) AS total_count"),
                DB::raw("SUM(COALESCE(products.product_price, 0)) AS product_price"),
                DB::raw("SUM(COALESCE(products.product_price, 0) * orders_products.count) AS total_price"),
                'orders.created_at'
            )
            ->whereNotNull('orders_products_customers.order_id')
            ->groupBy(
                'orders_products_customers.order_id',
                'customers.customer_name',
                'customers.phone',
                'orders_products_customers.created_at',
                'orders_products_customers.terms',
                'orders.created_at'
            )
            ->orderBy('orders.created_at', 'desc')
            ->get();



        return view('adminPanelOrders', compact('orders'));
    }

    public function adminPanelCustomers()
    {
        $customers=customers::all();

        return view('adminPanelCustomers', compact('customers'));
    }

    public function adminPanelProductCard($id)
    {
        if (!is_numeric($id)) {
            return redirect()->route('categories'); // Укажите маршрут, на который будет редирект
        }

        $product = Products::findOrFail($id);
        $categories = Categories::all(); // Все категории
        return view('adminPanelProductCard', compact('product', 'categories'));
    }


    public function ProductsUpdate(UpdateProductRequest $request, $id)
    {
        $product = Products::findOrFail($id);

        // Обновляем данные товара
        $product->product_name = $request->product_name;
        $product->product_price = $request->product_price;
        $product->product_color = $request->product_color;
        $product->product_memory = $request->product_memory ?? 'Не указано';
        $product->product_description = $request->product_description ?? 'Описание отсутствует';
        $product->categories_id = $request->categories_id;
        $product->availability = $request->has('availability') ? 1 : 0;

        // Обработка основного изображения
        if ($request->hasFile('main_image')) {
            $mainImage = $request->file('main_image');
            $mainImageName = time() . '_' . $mainImage->getClientOriginalName();
            $mainImage->move(public_path('img/catalog'), $mainImageName);
            $product->main_image = $mainImageName;
        }

        // Обработка дополнительных изображений
        if ($request->hasFile('product_images')) {
            $imagePaths = [];
            foreach ($request->file('product_images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('img/catalog'), $imageName);
                $imagePaths[] = $imageName;
            }
            $product->product_images = json_encode($imagePaths);
        }

        $product->updated_at = now();
        $product->save();

        return redirect()->route('adminPanelProductCard', $id)->with('success', 'Товар обновлён!');
    }
    public function CategoriesUpdate(UpdateCategoryRequest $request, $id)
    {
        Log::info('Метод CategoriesUpdate вызван', ['id' => $id]);

        $category = Categories::findOrFail($id);
        $category->name = $request->categories_name;

        if ($request->hasFile('product_img')) {
            $image = $request->file('product_img');
            $imageName = $image->getClientOriginalName();
            $image->move(resource_path('img/categories'), $imageName);
            $category->img = $imageName;
        }

        $category->updated_at = now();
        $category->save();

        Log::info('Категория обновлена', ['id' => $id, 'name' => $category->name]);

        return redirect()->route('adminPanelCategory')->with('success', 'Категория обновлена!');
    }


    public function CategoriesEdit($id)
    {
        if (!is_numeric($id)) {
            // Если $id не число, выполняем редирект
            return redirect()->route('adminPanelCategory'); // Укажите здесь нужный маршрут
        }
        // Получите продукт по ID
        $categories = Categories::findOrFail($id); // Найти продукт по ID или вернуть 404
        return view('adminPaneCategoryCard', compact('categories')); // Передаем продукт в виде массива
    }

    public function adminPanelUsers()
    {
        $users=User::all();

        return view('adminPanelUsers', compact('users'));
    }

    public function adminPanelinsertUsers($id) {

        if (!is_numeric($id)) {
            // Если $id не число, выполняем редирект
            return redirect()->route('adminPanelUsers'); // Укажите здесь нужный маршрут
        }
        // Получите продукт по ID
        $users = User::findOrFail($id); // Найти продукт по ID или вернуть 404
        return view('adminPanelinsertUsers', compact('users'));
    }

    public function usersUpdate(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->role = $request->role;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('adminPanelUsers')->with('success', 'Пользователь обновлён!');
    }

    public function deleteProduct(Request $request)
    {
        $productIds = $request->input('product_ids');
        if ($productIds) {
            Products::whereIn('id', $productIds)->delete();
        }
        return redirect()->route('adminPanel')->with('success', 'Выбранные товары удалены.');
    }

    public function createProduct()
    {
        $categories = Categories::all();
        return view('adminPanelProductCardCreate', compact('categories')); // Файл Blade-шаблона для создания товара
    }

    public function storeProduct(StoreProductRequest $request)
    {
        // Обрабатываем загрузку изображений
        $imagePaths = [];
        if ($request->hasFile('product_images')) {
            foreach ($request->file('product_images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName(); // Генерация уникального имени для изображения
                $image->move(public_path('img/catalog'), $imageName); // Перемещение файла в папку public/img/catalog
                $imagePaths[] = $imageName; // Добавляем имя файла в массив путей
            }
        }

        // Обрабатываем загрузку основного изображения
        $mainImageName = null;
        if ($request->hasFile('main_image')) {
            $mainImage = $request->file('main_image');
            $mainImageName = time() . '_main_' . $mainImage->getClientOriginalName(); // Генерация уникального имени для основного изображения
            $mainImage->move(public_path('img/catalog'), $mainImageName); // Перемещение файла в папку public/img/catalog
        }

        // Создание нового товара в базе данных
        Products::create([
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_color' => $request->product_color,
            'product_memory' => $request->product_memory ?? 0, // Если не указан, ставим 0
            'main_image' => $mainImageName, // Сохраняем имя основного изображения
            'product_images' => json_encode($imagePaths), // Сохраняем массив имен изображений в JSON
            'product_description' => $request->product_description,
            'categories_id' => $request->categories_id,
            'availability' => $request->has('availability') ? true : false, // Преобразуем в булево значение
        ]);

        // Перенаправляем пользователя с сообщением об успешном добавлении товара
        return redirect()->route('adminPanel')->with('success', 'Товар успешно добавлен!');
    }



    public function deleteCategories(Request $request)
    {
        // Получаем ID категорий из запроса
        $categoryIds = $request->input('category_ids', []);

        // Проверяем, что категории выбраны
        if (empty($categoryIds)) {
            return redirect()->route('adminPanelCategory')->with('error', 'Не выбраны категории для удаления.');
        }

        // Фильтруем некорректные ID (например, если они не числа)
        $categoryIds = array_filter($categoryIds, function ($id) {
            return is_numeric($id);
        });

        if (empty($categoryIds)) {
            return redirect()->route('adminPanelCategory')->with('error', 'Некорректные данные.');
        }

        // Удаляем категории и связанные товары
        DB::transaction(function () use ($categoryIds) {
            // Удаляем товары, связанные с выбранными категориями
            Products::whereIn('categories_id', $categoryIds)->delete();

            // Удаляем сами категории
            Categories::whereIn('id', $categoryIds)->delete();
        });

        return redirect()->route('adminPanelCategory')->with('success', 'Выбранные категории и связанные товары удалены.');
    }
    public function createCategory()
    {
        return view('adminPanelCategoryCreate'); // Файл Blade-шаблона для создания товара
    }


    public function storeCategory(StoreCategoryRequest $request)
    {
        $imagePath = null;

        if ($request->hasFile('categories_img')) {
            $image = $request->file('categories_img');
            $imageName = $image->getClientOriginalName();
            $image->move(resource_path('img/categories'), $imageName);
            $imagePath = $imageName;
        }

        Categories::create([
            'name' => $request->categories_name,
            'img' => $imagePath,
        ]);

        return redirect()->route('adminPanelCategory')->with('success', 'Категория успешно добавлена!');
    }

    public function deleteOrders(Request $request)
    {
        // Получаем ID заказов из запроса
        $orderIds = $request->input('order_ids', []);

        // Проверяем, что заказы выбраны
        if (empty($orderIds)) {
            return redirect()->route('adminPanelOrders')->with('error', 'Не выбраны заказы для удаления.');
        }

        // Фильтруем некорректные ID (например, если они не числа)
        $orderIds = array_filter($orderIds, function ($id) {
            return is_numeric($id);
        });

        if (empty($orderIds)) {
            return redirect()->route('adminPanelOrders')->with('error', 'Некорректные данные.');
        }

        // Удаляем заказы и связанные данные
        DB::transaction(function () use ($orderIds) {
            // Удаляем записи из таблицы orders_products_customers
            DB::table('orders_products_customers')
                ->whereIn('order_id', $orderIds)
                ->delete();

            // Удаляем записи из таблицы orders_products
            DB::table('orders_products')
                ->whereIn('orders_id', $orderIds)
                ->delete();

            // Удаляем записи из таблицы orders
            DB::table('orders')
                ->whereIn('id', $orderIds)
                ->delete();
        });

        return redirect()->route('adminPanelOrders')->with('success', 'Выбранные заказы удалены.');
    }


    public function UsersDelete(Request $request)
    {
        $usersIDs = $request->input('users_ids');

        if (empty($usersIDs)) {
            return redirect()->route('adminPanelUsers')->with('error', 'Не выбраны пользователи для удаления.');
        }

        $users = User::whereIn('id', $usersIDs)->get();

        DB::transaction(function () use ($users) {
            foreach ($users as $user) {
                // Находим клиента по email
                $customer = customers::where('email', $user->email)->first();

                if ($customer) {
                    // Получаем все order_id, связанные с этим клиентом
                    $orderIds = DB::table('orders_products_customers')
                        ->where('customer_id', $customer->id)
                        ->pluck('order_id');

                    if ($orderIds->isNotEmpty()) {
                        // Удаляем связанные записи
                        DB::table('orders_products_customers')->whereIn('order_id', $orderIds)->delete();
                        DB::table('orders_products')->whereIn('orders_id', $orderIds)->delete();
                        DB::table('orders')->whereIn('id', $orderIds)->delete();
                    }
                }

                // Удаляем пользователя
                $user->delete();
            }
        });

        return redirect()->route('adminPanelUsers')->with('success', 'Пользователи и их заказы успешно удалены.');
    }



    public function createUser()
    {
        return view('adminPanelUsersCreate'); // Файл Blade-шаблона для создания товара
    }

    public function storeUser(StoreUserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            'surname' => ' ',
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('adminPanelUserCreate')->with('success', 'Пользователь успешно добавлен!');
    }


    public function deleteCustomers(Request $request)
    {
        $customerIds = $request->input('customers_ids', []);

        if (empty($customerIds)) {
            return redirect()->route('adminPanel')->with('error', 'Не выбраны клиенты для удаления.');
        }

        // Фильтруем некорректные ID
        $customerIds = array_filter($customerIds, fn($id) => is_numeric($id));

        if (empty($customerIds)) {
            return redirect()->route('adminPanel')->with('error', 'Некорректные данные.');
        }

        DB::transaction(function () use ($customerIds) {
            // Удаляем заказы клиентов
            $orderIds = DB::table('orders_products_customers')
                ->whereIn('customer_id', $customerIds)
                ->pluck('order_id')
                ->toArray();

            if (!empty($orderIds)) {
                DB::table('orders_products_customers')->whereIn('order_id', $orderIds)->delete();
                DB::table('orders_products')->whereIn('orders_id', $orderIds)->delete();
                DB::table('orders')->whereIn('id', $orderIds)->delete();
            }

            // Удаляем клиентов
            DB::table('customers')->whereIn('id', $customerIds)->delete();
        });

        return redirect()->route('adminPanelCustomers')->with('success', 'Выбранные клиенты и их заказы удалены.');
    }

    public function adminPanelFilter(Request $request) {
        $categories = Categories::all();
        $productsQuery = Products::query();

        // Фильтр по наименованию
        if ($request->has('name') && $request->name != '') {
            $productsQuery->where('product_name', 'like', '%' . $request->name . '%');
        }

        // Фильтр по цене
        if ($request->has('price1') && $request->price1 != '') {
            $productsQuery->where('product_price', '>=', $request->price1);
        }
        if ($request->has('price2') && $request->price2 != '') {
            $productsQuery->where('product_price', '<=', $request->price2);
        }

        // Фильтр по номеру категории
        if ($request->has('category_id') && $request->category_id != '') {
            $productsQuery->where('categories_id', $request->category_id);
        }

        // Фильтр по наличию
        if ($request->has('availability') && $request->availability != 'all') {
            $productsQuery->where('availability', $request->availability == 'available' ? 1 : 0);
        }

        $products = $productsQuery->get();

        return view('adminPanel', compact('categories', 'products'));
    }



    public function adminPanelCategoryFilter(Request $request)
    {
        // Получаем все категории
        $categoriesQuery = Categories::query();

        // Фильтр по наименованию категории
        if ($request->has('name') && $request->name != '') {
            $searchTerm = '%' . strtolower($request->name) . '%';
            $categoriesQuery->whereRaw('LOWER(name) LIKE ?', [$searchTerm]);
        }

        // Сортировка по количеству товаров
        if ($request->has('sort_quantity')) {
            $sortDirection = $request->sort_quantity === 'asc' ? 'asc' : 'desc';
            $categoriesQuery->withCount('products') // Подсчет количества товаров
            ->orderBy('products_count', $sortDirection);
        }

        // Получаем отфильтрованные и отсортированные категории
        $categoriess = $categoriesQuery->get();
        $products = Products::all();

        return view('adminPanelCategory', compact('categoriess', 'products'));
    }


    public function adminPanelOrdersFilter(Request $request)
    {
        // Основной запрос для заказов
        $ordersQuery = DB::table('orders_products_customers')
            ->leftJoin('orders', 'orders_products_customers.order_id', '=', 'orders.id')
            ->leftJoin('customers', 'orders_products_customers.customer_id', '=', 'customers.id')
            ->leftJoin('orders_products', 'orders_products_customers.order_id', '=', 'orders_products.orders_id')
            ->leftJoin('products', 'orders_products.products_id', '=', 'products.id')
            ->select(
                'orders_products_customers.order_id',
                DB::raw("COALESCE(customers.customer_name, 'Неизвестный клиент') AS customer_name"),
                'customers.phone',
                'orders_products_customers.created_at',
                'orders_products_customers.terms',
                DB::raw("STRING_AGG(products.product_name, ', ') AS product_names"),
                DB::raw("SUM(orders_products.count) AS total_count"),
                DB::raw("SUM(COALESCE(products.product_price, 0)) AS product_price"),
                DB::raw("SUM(COALESCE(products.product_price, 0) * orders_products.count) AS total_price"),
                'orders.created_at'
            )
            ->whereNotNull('orders_products_customers.order_id')
            ->groupBy(
                'orders_products_customers.order_id',
                'customers.customer_name',
                'customers.phone',
                'orders_products_customers.created_at',
                'orders_products_customers.terms',
                'orders.created_at'
            );

        // Фильтр по номеру заказа
        if ($request->has('order_id') && $request->order_id != '') {
            $ordersQuery->where('orders_products_customers.order_id', 'like', '%' . $request->order_id . '%');
        }

        // Фильтр по имени клиента
        if ($request->has('customer_name') && $request->customer_name != '') {
            $ordersQuery->where('customers.customer_name', 'like', '%' . $request->customer_name . '%');
        }

        // Фильтр по номеру телефона
        if ($request->has('phone') && $request->phone != '') {
            $ordersQuery->where('customers.phone', 'like', '%' . $request->phone . '%');
        }

        // Сортировка по цене
        if ($request->has('sort_price')) {
            $sortDirection = $request->sort_price === 'asc' ? 'asc' : 'desc';
            $ordersQuery->orderBy('total_price', $sortDirection);
        }

        // Получаем отфильтрованные и отсортированные заказы
        $orders = $ordersQuery->get();

        return view('adminPanelOrders', compact('orders'));
    }


    public function adminPanelUsersFilter(Request $request)
    {
        // Основной запрос для пользователей
        $usersQuery = User::query();

        // Фильтр по электронной почте
        if ($request->has('email') && $request->email != '') {
            $usersQuery->where('email', 'like', '%' . $request->email . '%');
        }


        // Фильтр по роли
        if ($request->has('role') && $request->role != '') {
            $usersQuery->where('role', $request->role);
        }

        // Сортировка по имени пользователя
        if ($request->has('sort_name')) {
            $sortDirection = $request->sort_name === 'asc' ? 'asc' : 'desc';
            $usersQuery->orderBy('name', $sortDirection);
        }

        // Получаем отфильтрованных и отсортированных пользователей
        $users = $usersQuery->get();

        return view('adminPanelUsers', compact('users'));
    }


    public function adminPanelCustomersFilter(Request $request)
    {
        // Основной запрос для клиентов
        $customersQuery = customers::query();

        // Фильтр по имени клиента
        if ($request->has('customer_name') && $request->customer_name != '') {
            $customersQuery->where('customer_name', 'like', '%' . $request->customer_name . '%');
        }

        // Фильтр по номеру телефона
        if ($request->has('phone') && $request->phone != '') {
            $customersQuery->where('phone', 'like', '%' . $request->phone . '%');
        }

        // Сортировка по имени клиента
        if ($request->has('sort_name')) {
            $sortDirection = $request->sort_name === 'asc' ? 'asc' : 'desc';
            $customersQuery->orderBy('customer_name', $sortDirection);
        }

        // Сортировка по дате регистрации
        if ($request->has('sort_date')) {
            $sortDirection = $request->sort_date === 'asc' ? 'asc' : 'desc';
            $customersQuery->orderBy('created_at', $sortDirection);
        }

        // Получаем отфильтрованных и отсортированных клиентов
        $customers = $customersQuery->get();

        return view('adminPanelCustomers', compact('customers'));
    }


    public function userOrders(Request $request)
    {
        $user = Auth::user();
        $customer = DB::table('customers')->where('email', $user->email)->first();
        if (!$customer) {
            return view('UsersMyOrders', ['orders' => collect()]);
        }
        $orders = DB::table('orders_products_customers')
            ->leftJoin('orders', 'orders_products_customers.order_id', '=', 'orders.id')
            ->leftJoin('customers', 'orders_products_customers.customer_id', '=', 'customers.id')
            ->leftJoin('orders_products', 'orders_products_customers.order_id', '=', 'orders_products.orders_id')
            ->leftJoin('products', 'orders_products.products_id', '=', 'products.id')
            ->select(
                'orders_products_customers.order_id',
                DB::raw("COALESCE(customers.customer_name, 'Неизвестный клиент') AS customer_name"),
                'customers.phone',
                'orders_products_customers.created_at',
                'orders_products_customers.terms',
                DB::raw("STRING_AGG(products.product_name, ', ') AS product_names"),
                DB::raw("SUM(orders_products.count) AS total_count"),
                DB::raw("SUM(COALESCE(products.product_price, 0)) AS product_price"),
                DB::raw("SUM(COALESCE(products.product_price, 0) * orders_products.count) AS total_price"),
                'orders.created_at'
            )
            ->whereNotNull('orders_products_customers.order_id')
            ->where('orders_products_customers.customer_id', $customer->id)
            ->groupBy(
                'orders_products_customers.order_id',
                'customers.customer_name',
                'customers.phone',
                'orders_products_customers.created_at',
                'orders_products_customers.terms',
                'orders.created_at'
            )
            ->orderBy('orders.created_at', 'desc')
            ->get();
        return view('UsersMyOrders', compact('orders'));
    }
    public function UsersMyOrdersDelete(Request $request)
    {
        $user = auth()->user();
        $orderId = $request->input('order_id');

        if (!$orderId) {
            return redirect()->back()->with('error', 'Не передан ID заказа.');
        }

        // Найдём клиента по email пользователя
        $customer = customers::where('email', $user->email)->first();

        if (!$customer) {
            return redirect()->back()->with('error', 'Клиент не найден.');
        }

        // Проверим, принадлежит ли заказ этому клиенту
        $orderCustomer = DB::table('orders_products_customers')
            ->where('order_id', $orderId)
            ->where('customer_id', $customer->id)
            ->first();

        if (!$orderCustomer) {
            return redirect()->back()->with('error', 'Этот заказ вам не принадлежит.');
        }

        // Удалим заказ клиента
        DB::table('orders_products_customers')
            ->where('order_id', $orderId)
            ->where('customer_id', $customer->id)
            ->delete();

        return redirect()->back()->with('success', 'Заказ успешно отменён.');
    }
}
