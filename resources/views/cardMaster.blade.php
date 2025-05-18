<div class="close-cartContainer">
    <form id="delete-to-cart-form" action="{{ route('cart.remove', ['id' => $product->id]) }}" method="POST">
        @csrf
        <button type="submit" class="close-cart" id="close-cart">
            <img src="{{ Vite::asset('resources/img/cart/x-circle.png') }}" alt="close-cartImg"/>
        </button>
    </form>
</div>

<div class="order-info">
    <a href="#" class="card__imageCartPage">
        @php
            // Декодируем JSON в массив
            $images = json_decode($product->product_images, true);
            // Берем первое изображение из массива
            $firstImage = $images[0] ?? 'imagenotfound.png';
        @endphp
        <img
            src="{{ asset('img/catalog/' . $firstImage) }}"
            alt="{{ $product->product_name }}"
            class="imgCartPage"
        />
    </a>

    <div class="order-text">
        <a href="{{ route('cartProduct', ['id' => $product->id]) }}" class="order-name" id="order-name">
            {{ $product->product_name }}, {{ $product->product_color }}
        </a>
    </div>
    <div class="order-price">
        {{$product->product_price * $product->count}} ₽
    </div>
</div>

<div class="order-final_container">
    <div class="quantity-selector">
        <label for="quantity">Количество:</label>

        {{-- Кнопка уменьшения количества --}}
        <form action="{{ route('cart.decrement', ['id' => $product->id]) }}" method="POST">
            @csrf
            <button type="submit" class="quantity-btn" id="decrement">-</button>
        </form>

        <div class="number">
            {{ $product->count }}
        </div>

        {{-- Кнопка увеличения количества --}}
        <form action="{{ route('cart.add', ['id' => $product->id]) }}" method="POST">
            @csrf
            <button type="submit" class="quantity-btn" id="increment">+</button>
        </form>
    </div>
</div>
