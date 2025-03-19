@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp

@section('content')


<div class="cart-container">
    <div class="cart-shopping">
        <div class="cart-title">
            Ваш заказ
        </div>

        <div class="order-info">
            <a href="#" class="card__image">
                <img
                    src="{{ Vite::asset('resources/img/catalog/iphone14.png') }}"
                    alt="Apple IPhone 14"
                />
            </a>
            <div class="order-text">
                <div class="order-name">
                    Смартфон Apple IPhone 14 Pro Max 256Gb, золотой
                </div>
            </div>
        </div>

        <div class="price-container">
            <div class="cart-price_left">
                Итого:
            </div>
            <div class="cart-price_right">
                14440 рублей
            </div>
        </div>
        <div class="order-final_container">
            <div class="quantity-selector">
                <label for="quantity">Количество:</label>
                <button id="decrement">-</button>
                <input type="number" id="quantity" name="quantity" value="1" min="1" readonly>
                <button id="increment">+</button>
            </div>
            <div class="order-button">
                <button name="cart-order" class="card-order">Оформить заказ</button>
            </div>
        </div>

    </div>
</div>

<script type="module" src="<?php echo Vite::asset('resources/js/cart.js'); ?>"></script>

</body>
</html>

@endsection
