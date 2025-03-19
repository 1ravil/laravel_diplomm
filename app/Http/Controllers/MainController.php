<?php

namespace App\Http\Controllers;

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
            // Если $id не число, выполняем редирект
            return redirect()->route('categories'); // Укажите здесь нужный маршрут
        }
        // Получите продукт по ID
        $product = Products::findOrFail($id); // Найти продукт по ID или вернуть 404
        return view('adminPanelProductCard', compact('product')); // Передаем продукт в виде массива
    }

    public function ProductsUpdate(Request $request, $id)
    {
        Log::info('Метод ProductsUpdate вызван', ['id' => $id]);
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric',
            'product_color' => 'required|string|max:50',
            'product_memory' => 'nullable|string|max:255',
            'product_description' => 'nullable|string',
            'product_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories_id' => 'required|integer',
            'availability' => 'nullable|boolean',
        ]);

        $product = Products::findOrFail($id);

        $product->product_name = $request->product_name;
        $product->product_price = $request->product_price;
        $product->product_color = $request->product_color;
        $product->product_memory = $request->product_memory ?? 'Не указано';
        $product->product_description = $request->product_description ?? 'Описание отсутствует';
        $product->categories_id = $request->categories_id;
        $product->availability = $request->has('availability') ? 1 : 0;
        if ($request->hasFile('product_img')) {
            $image = $request->file('product_img');
            $imageName = $image->getClientOriginalName(); // Берем оригинальное имя файла
            $image->move(resource_path('img/catalog'), $imageName); // Сохраняем файл в нужную папку
            $product->product_img = $imageName; // В БД сохраняем только имя файла
        }



        $product->updated_at = now();
        $product->save();

        Log::info('Продукт обновлён', ['id' => $id, 'name' => $product->product_name]);

        return redirect()->route('adminPanelProductCard', $id)->with('success', 'Товар обновлён!');
    }
    public function CategoriesUpdate(Request $request, $id)
    {
        Log::info('Метод CategoriesUpdate вызван', ['id' => $id]);

        $request->validate([
            'categories_name' => 'required|string|max:255',
            'product_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

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

    public function usersUpdate(Request $request, $id)
    {
        Log::info('Метод usersUpdate вызван', ['id' => $id]);

        // Валидация данных
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:50',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        // Найти пользователя
        $user = User::findOrFail($id);

        // Обновляем данные
        $user->name = $request->name;
        $user->role = $request->role;
        $user->email = $request->email;

        // Если передан новый пароль — хешируем и сохраняем
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Сохраняем изменения
        $user->save();

        Log::info('Пользователь обновлён', ['id' => $id, 'name' => $user->name]);

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
        return view('adminPanelProductCardCreate'); // Файл Blade-шаблона для создания товара
    }

    public function storeProduct(Request $request)
    {
        // Валидация данных
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric',
            'product_color' => 'required|string|max:50',
            'product_memory' => 'nullable|string|max:255',
            'product_description' => 'required|string',
            'product_images' => 'required|array|min:4', // Минимум 4 фотографии
            'product_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Каждая фотография должна быть изображением
            'categories_id' => 'required|integer',
            'availability' => 'nullable|boolean',
        ]);

        // Обрабатываем загрузку изображений
        $imagePaths = [];
        if ($request->hasFile('product_images')) {
            foreach ($request->file('product_images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName(); // Уникальное имя файла
                $image->move(resource_path('img/catalog'), $imageName); // Сохраняем файл в папку
                $imagePaths[] = $imageName; // Сохраняем имя файла в массив
            }
        }

        // Создаем товар
        Products::create([
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_color' => $request->product_color,
            'product_memory' => $request->product_memory,
            'product_images' => json_encode($imagePaths), // Сохраняем массив фотографий в формате JSON
            'product_description' => $request->product_description,
            'categories_id' => $request->categories_id,
            'availability' => $request->availability ?? true,
        ]);

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


    public function storeCategory(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'categories_name' => 'required|string|max:255',
            'categories_img' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Handle the uploaded category image
        if ($request->hasFile('categories_img')) {
            $image = $request->file('categories_img');
            $imageName = $image->getClientOriginalName(); // Add timestamp to avoid name conflicts
            $image->move(resource_path('img/categories'), $imageName); // Store image in the 'public/img/categories' folder
            $imagePath = 'img/categories/' . $imageName; // Store the relative path
            $imagePath = $imageName; // В БД сохраняем только имя файла
        } else {
            $imagePath = null; // If no image is provided, set it to null
        }
        // Create a new category record in the 'categories' table
        Categories::create([
            'name' => $request->categories_name,
            'img' => $imagePath, // Save the image path
        ]);

        // Redirect with a success message
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
        if ($usersIDs) {
            User::whereIn('id', $usersIDs)->delete();
        }
        return redirect()->route('adminPanelUsers')->with('success', 'Выбранные товары удалены.');
    }


    public function createUser()
    {
        return view('adminPanelUsersCreate'); // Файл Blade-шаблона для создания товара
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|numeric',
            'email' => 'required|email|max:255|unique:users,email', // Исправлено
            'password' => 'nullable|string|min:6',
        ]);


        User::create([
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            'surname' => ' ',
            'password' => bcrypt($request->password), // Хеширование пароля
        ]);

        return redirect()->route('adminPanelUserCreate')->with('success', 'Товар успешно добавлен!');
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

}
