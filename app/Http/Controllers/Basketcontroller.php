<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\create_orders_products_customers_table;
use App\Models\Customers;
use App\Models\orders;
use App\Models\orders_products;
use App\Models\Products;
use App\Models\OrdersProductsCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class basketcontroller extends Controller
{
    public function cart()
    {
        return view('cart');
    }
    public function cartProduct()
    {
        $products= Products::all();
        return view('cartProduct', compact('products'));
    }

    public function show($id)
    {
        if (!is_numeric($id)) {
            // Если $id не число, выполняем редирект
            return redirect()->route('categories'); // Укажите здесь нужный маршрут
        }
        // Получите продукт по ID
        $product = Products::findOrFail($id); // Найти продукт по ID или вернуть 404
        return view('cartProduct', compact('product')); // Передаем продукт в виде массива
    }

    public function add($id)
    {
        // Получаем текущую корзину из сессии
        $cart = session('products', []);

        // Проверяем, есть ли уже этот товар в корзине
        if (isset($cart[$id])) {
            $cart[$id]['count']++;
        } else {
            $product = Products::find($id);
            if (!$product) {
                return redirect()->back()->with('error', 'Товар не найден.');
            }

            // Добавляем новый товар в корзину
            $cart[$id] = [
                'id' => $product->id,
                'product_name' => $product->product_name,
                'product_color' => $product->product_color,
                'price' => $product->product_price,
                'count' => 1,
                'image' => $product->product_img ?? null,
            ];
        }

        // Записываем корзину обратно в сессию (теперь корзина обновляется, а не перезаписывается)
        session(['products' => $cart]);

        // Проверяем, есть ли уже заказ в сессии
        if (!session()->has('orderId')) {
            $order = Orders::create([
                'status' => 1, // Вместо 'pending' передаем числовое значение
                'total_price' => 0, // Пока 0, обновится при оформлении
            ]);

            // Сохраняем id заказа в сессии
            session(['orderId' => $order->id]);
        }

        return redirect()->route('cartPage');
    }


    // Уменьшить количество товара
    public function decrement($id)
    {
        $cart = session('products', []);

        if (isset($cart[$id])) {
            if ($cart[$id]['count'] > 1) {
                $cart[$id]['count']--;
            } else {
                unset($cart[$id]); // Если 1 товар – удалить из корзины
            }
            session(['products' => $cart]);
        }

        return redirect()->route('cartPage');
    }

    // Удалить товар из корзины
    public function remove($id)
    {
        $cart = session('products', []);
        unset($cart[$id]);
        session(['products' => $cart]);

        return redirect()->route('cartPage');
    }
    public function basketRemove(Request $request, $products_id)
    {
        // Получаем orderId из сессии
        $orderId = session('orderId');

        // Если orderId отсутствует, перенаправляем на страницу корзины
        if (is_null($orderId)) {
            return redirect()->route('cartPage');
        }

        // Находим заказ
        $order = orders::find($orderId);

        // Проверяем, содержится ли товар в заказе
        if ($order->products->contains($products_id)) {
            $pivotRow = $order->products()->where('products_id', $products_id)->first()->pivot;

            // Уменьшаем количество товара
            if ($pivotRow->count > 1) {
                $pivotRow->count--;
                $pivotRow->update();
            } else {
                // Если количество товара = 1, удаляем товар из заказа
                $order->products()->detach($products_id);

                // Удаляем товар из сессии
                $products = session('products', collect());
                $products = $products->reject(function ($item) use ($products_id) {
                    return $item->id == $products_id; // Удаляем товар по ID
                });
                session(['products' => $products]);
            }
        }

        return redirect()->route('cartPage');
    }
    public function cartPage()
    {
        // Получаем товары из сессии
        $cartItems = session('products', []);

        // Если корзина не пуста, получаем данные о товарах из БД
        if (!empty($cartItems)) {
            $productIds = array_keys($cartItems); // Получаем все ID товаров
            $products = Products::whereIn('id', $productIds)->get(); // Загружаем товары из БД

            // Добавляем количество к каждому товару
            $products = $products->map(function ($product) use ($cartItems) {
                $product->count = $cartItems[$product->id]['count'];
                return $product;
            });
        } else {
            $products = collect(); // Пустая коллекция, если товаров нет
        }

        return view('cartPage', compact('products'));
    }

    public function removeProduct($products_id)
    {
        // Получаем orderId из сессии
        $orderId = session('orderId');

        // Если orderId отсутствует, перенаправляем на страницу корзины
        if (is_null($orderId)) {
            return redirect()->route('cartPage');
        }

        // Находим заказ
        $order = orders::find($orderId);

        // Проверяем, содержится ли товар в заказе
        if ($order->products->contains($products_id)) {
            // Полностью удаляем товар из заказа
            $order->products()->detach($products_id);

            // Удаляем товар из сессии
            $products = session('products', collect());
            $products = $products->reject(function ($item) use ($products_id) {
                return $item->id == $products_id; // Удаляем товар по ID
            });
            session(['products' => $products]);
        }

        return redirect()->route('cartPage');
    }
    public function placeOrder()
    {
        $orderId = session('orderId');
        $order = Orders::find($orderId);

        if (!$order) {
            session()->forget('orderId'); // Очистить неверный ID
            return redirect()->route('cartPage')->with('error', 'Ошибка: заказ не найден.');
        }

        // Находим заказ
        $order = Orders::find($orderId);

        // Получаем товары из сессии (из ключа 'products')
        $cart = session('products', []);

        // Если корзина пуста, отладочный вывод
        if (empty($cart)) {
            dd('Корзина пуста', session()->all());
        }

        // Вычисляем общую сумму
        $totalPrice = collect($cart)->sum(fn($p) => ($p['price'] ?? 0) * $p['count']);
        $discount = $totalPrice * 0.09; // 9% скидки
        $finalPrice = $totalPrice - $discount;
        return view('placeAnOrder', compact('order', 'cart', 'totalPrice', 'discount', 'finalPrice'));
    }



    public function sendOrder(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:15',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        // Получаем orderId из сессии
        $orderId = session('orderId');

        // Проверяем, есть ли товары в корзине
        $cart = session('products', []);
        if (empty($cart)) {
            return redirect()->route('cartPage')->with('error', 'Корзина пуста');
        }

        // Если заказа нет в сессии или он не найден в БД, создаем новый
        $order = Orders::find($orderId);
        if (!$order) {
            $order = Orders::create([
                'status' => 1, // Заказ в ожидании
                'total_price' => 0, // Позже пересчитаем
            ]);
            session(['orderId' => $order->id]); // Сохраняем в сессии
        }

        // Проверяем, существует ли клиент с таким email
        $customer = Customers::firstOrCreate(
            ['email' => $request->email],
            [
                'customer_name' => $request->name,
                'customer_surname' => '',
                'phone' => $request->phone,
            ]
        );

        // Добавляем товары в заказ, если их ещё нет
        foreach ($cart as $productData) {
            $existingProduct = orders_products::where([
                'orders_id' => $order->id,
                'products_id' => $productData['id'],
            ])->first();

            if ($existingProduct) {
                // Если товар уже в заказе, обновляем количество
                $existingProduct->count += $productData['count'];
                $existingProduct->save();
            } else {
                // Если товара нет, создаем новую запись
                orders_products::create([
                    'orders_id' => $order->id,
                    'products_id' => $productData['id'],
                    'count' => $productData['count'],
                ]);
            }
        }

        // Привязываем заказ к клиенту
        create_orders_products_customers_table::updateOrCreate(
            ['order_id' => $order->id, 'customer_id' => $customer->id],
            ['terms' => $request->has('terms')]
        );

        // Вычисляем общую сумму заказа
        $totalPrice = collect($cart)->sum(fn($p) => ($p['price'] ?? 0) * $p['count']);
        $discount = $totalPrice * 0.09; // 9% скидки
        $finalPrice = $totalPrice - $discount;

        // Обновляем заказ с новой ценой
        $order->update(['total_price' => $finalPrice]);

        // Очищаем корзину
        session()->forget(['products', 'orderId']);

        return redirect()->route('placeOrder', ['id' => $order->id])->with('success', 'Заказ успешно оформлен!');
    }





}
