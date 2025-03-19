@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp
@section('title', $product->product_name )
@section('content')


    <div class="cartProductTitle-container">
        <div class="cartProduct-Title">
            Информация о товаре
        </div>
    </div>
    <div class="cartProduct-container1">
        <div class="cartProduct-imageContainer">
            @if($product->product_images && count(json_decode($product->product_images)) > 0)
                <div class="cartProduct_gallery-thumbnails">
                    @foreach(json_decode($product->product_images) as $index => $image)
                        <img src="{{ Vite::asset('resources/img/catalog/' . $image) }}"
                             alt="Фото товара {{ $index + 1 }}"
                             class="thumbnail {{ $index === 0 ? 'active' : '' }}"
                             data-image="{{ Vite::asset('resources/img/catalog/' . $image) }}">
                    @endforeach
                </div>
                <div class="card__image">
                    <img src="{{ Vite::asset('resources/img/catalog/' . json_decode($product->product_images)[0]) }}"
                         alt="Основное фото товара"
                         id="main-product-image"/>
                </div>
            @else
                <div class="cartProductWarning">
                    <img src="{{ Vite::asset('resources/img/catalog/imagenotfound.png')}}"
                         alt="Фото не найдено"
                         id="main-product-image" class="notfoundimg"/>
                </div>
            @endif
        </div>
        <div class="cartProductInfo-container">
            <div class="badges">
                <span class="badge">Гарантия</span>
                    <div class="cartProductNameInfo">
                        {{ $product->product_name, $product->product_color}}
                    </div>
                <div class="color-selection">
                    <h3>Цвет</h3>
                    <div class="color-options">
                        @php
                            // Получаем текущий цвет продукта
                            $currentColor = strtolower($product->product_color ?? '');

                            // Массив возможных цветов
                            $colors = [
                                'black', 'white', 'gray', 'silver', 'red', 'green', 'blue', 'yellow', 'purple', 'cyan', 'magenta',
                                'orange', 'brown', 'pink', 'teal', 'lime', 'indigo', 'violet', 'beige', 'ivory', 'navy', 'maroon',
                                'chocolate', 'coral', 'turquoise', 'fuchsia', 'gold', 'khaki', 'lavender', 'plum', 'orchid', 'salmon',
                                'tomato', 'crimson', 'sienna', 'tan', 'chartreuse', 'aquamarine', 'mintcream', 'snow', 'seashell',
                                'oldlace', 'floralwhite', 'ghostwhite', 'whitesmoke', 'gainsboro', 'lightgray', 'darkgray', 'lightslategray',
                                'slategray', 'darkslategray', 'mediumslateblue', 'midnightblue', 'blueviolet', 'mediumvioletred', 'lawngreen',
                                'mediumseagreen', 'seagreen', 'forestgreen', 'darkgreen', 'darkolivegreen', 'olive', 'olivedrab', 'yellowgreen',
                                'limegreen', 'forestgreen', 'darkseagreen', 'lightgreen', 'palegreen', 'springgreen', 'chartreuse', 'lightgoldenrodyellow',
                                'lightyellow', 'goldenrod', 'darkgoldenrod', 'yellowgreen', 'greenyellow'
                            ];
                        @endphp

                        @if(in_array($currentColor, $colors))
                            <button class="color-btn {{ $currentColor }} active" data-color="{{ ucfirst($currentColor) }}"></button>
                        @endif
                        <div class="cartProductColor">
                            {{$product -> product_color}}
                        </div>



                    </div>
                </div>




            </div>

                    @if($product->product_memory != 0)
                    <div class="storage-selection">

                        <h3>Память</h3>
                        <div class="storage-options">
                            <button class="storage-btn">{{$product->product_memory}}</button>
                        </div>
                    </div>
                    @endif
                    <!-- Price -->
                    <div class="price-section">
                        <div class="price">
                            <span class="current-price">{{$product->product_price * 0.9}}</span>
                            <span class="original-price">{{$product->product_price}} </span>
                        </div>
                    </div>

                    <!-- Delivery Options -->
                    <div class="delivery-options">
                        <div class="delivery-option">
                            <div class="option-left">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 12h18M3 12a9 9 0 0 1 9-9M3 12a9 9 0 0 0 9 9"/>
                                    <path d="M21 12a9 9 0 0 0-9-9M21 12a9 9 0 0 1-9 9"/>
                                </svg>
                                <span>Курьером</span>
                            </div>
                            <span class="free-delivery">Бесплатно</span>
                        </div>
                        <div class="delivery-option">
                            <div class="option-left">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 3h18v18H3z"/>
                                    <path d="M3 9h18"/>
                                    <path d="M9 21V9"/>
                                </svg>
                                <span>Забрать в магазине &nbsp;</span>
                            </div>
                            <span class="free-delivery">Бесплатно</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">



                        <form id="add-to-cart-form" action="{{ route('cartProduct.add', $product) }}" method="POST">
                            @csrf
                            <button type="submit" class="primary-btn" role="button">
                                В корзину
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="product-container">
        <div class="product-tabs">
            <nav class="tabs-nav">
                <button class="tab-btn active" data-tab="description">ОПИСАНИЕ И ХАРАКТЕРИСТИКИ</button>
                <button class="tab-btn" data-tab="address">АДРЕС</button>
                <button class="tab-btn" data-tab="reviews">ОТЗЫВЫ</button>
                <button class="tab-btn" data-tab="how-to-buy">КАК КУПИТЬ</button>
                <button class="tab-btn" data-tab="payment">ОПЛАТА</button>
            </nav>

            <div class="tab-content active" id="description">
                <h2>Описание смартфона {{ $product->product_name, $product->product_color}}</h2>
                {!! nl2br(e($product->product_description)) !!}
                 </div>



            <div class="tab-content" id="address">
                <h2>Адрес магазина</h2>
                <p>г. Уфа, ул. Ленина, д. 100</p>
                <p>Время работы: 10:00 - 22:00</p>
            </div>

            <div class="tab-content" id="reviews">
                <h2>Отзывы покупателей</h2>
                <div class="review">
                    <p>Отличный телефон! Камера супер!</p>
                    <footer>- Александр</footer>
                </div>
            </div>

            <div class="tab-content" id="how-to-buy">
                <h2>Как купить</h2>
                <ol>
                    <li>Выберите товар</li>
                    <li>Добавьте в корзину</li>
                    <li>Оформите заказ</li>
                    <li>Выберите способ доставки</li>
                </ol>
            </div>

            <div class="tab-content" id="payment">
                <h2>Способы оплаты</h2>
                <ul>
                    <li>Банковской картой</li>
                    <li>Наличными при получении</li>
                    <li>СБП</li>
                </ul>
            </div>
        </div>
    </div>

    @vite('resources/js/scriptCartProduct.js')
@endsection
