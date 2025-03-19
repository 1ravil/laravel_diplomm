<div class="card_Catalog">
    <!-- Верхняя часть -->
    <div class="card__top_Catalog">
        <!-- Изображение-ссылка товара -->
        <a href="#" class="card__image_Catalog">
            @php
                // Декодируем JSON в массив
                $images = json_decode($product->product_images, true);
                // Берем первое изображение из массива
                $firstImage = $images[0] ?? 'imagenotfound.png'; // Если массив пуст, используем изображение по умолчанию
            @endphp
            <img
                src="{{ Vite::asset('resources/img/catalog/' . $firstImage) }}"
                alt="{{ $product->product_name }}"
            />
        </a>
        <!-- Скидка на товар -->
        <div class="card__label_Catalog">-10%</div>
    </div>
    <!-- Нижняя часть -->
    <div class="card__bottom_Catalog">
        <!-- Цены на товар (с учетом скидки и без)-->
        <div class="card__prices">
            <div class="card__price card__price--discount">{{ $product->product_price * 0.9 }}</div>
            <div class="card__price card__price--common">{{ $product->product_price }}</div>
        </div>
        <!-- Ссылка-название товара -->
        <a href="{{ route('cartProduct', ['id' => $product->id]) }}" class="card__title_Catalog">
            {{ $product->product_name }}, {{ $product->product_color }}
        </a>

        <form id="add-to-cart-form" action="{{ route('cartProduct.add', $product) }}" method="POST">
            @csrf
            <button type="submit" class="card__add buy-button js-buy-button" role="button">
                В корзину
            </button>
        </form>
    </div>
</div>
