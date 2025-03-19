@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp

@section('title', 'Корзина'  )

@section('content')
    <div class="cart-containerFlex">
        <div class="cartPage-Title">
            Корзина
        </div>
    </div>


    <div class="cart-containerFlex">
        <div class="cart-container" id="cart">
            <div class="cart-shopping">


                <div class="cart-title">
                    Ваш заказ
                </div>


                 @if($products->isEmpty())
                    <div class="empty-cart-message_Container">
                        <div class="empty-cart-message">
                            Похоже, вы еще не добавили товары в свою корзину. <br>Не упустите возможность найти то, что вам нужно!
                        </div>
                        <div class="empty-cart-messageBtnContainer">
                            <div class="empty-cart-messageBtn">
                                <a class="btn" href="{{ route('catalog') }}">Перейти в каталог</a>
                            </div>
                        </div>
                    </div>
                @else
                    @foreach($products as $product)
                        @include('cardMaster', compact('product'))
                    @endforeach


                        <div class="orderPlace-final_container">
                            <div class="order-button">
                                <a href="{{ route('placeOrder', ['id' => session('orderId')]) }}">
                                    @csrf
                                    <button name="cart-order" class="card-order">Оформить заказ</button>
                                </a>
                            </div>
                        </div>


                        <div class="price-container">
                            <div class="cart-price_left">
                                Итого:
                            </div>
                            <div class="cart-price_right" id="cart-price">
                                {{ collect($products)->sum(fn($p) => $p['product_price'] * $p['count']) }} ₽
                            </div>
                        </div>
                    </div>

                @endif

                @vite('resources/js/scriptCatalog.js')


            </div>
        </div>
    </div>


</div>

@endsection
