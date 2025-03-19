@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp

@section('title', 'Корзина'  )

@section('content')

    <div class="checkout-formTextContainer">
        <div class="checkout-formText">
            Оформление заказа
        </div>
    </div>


    <div class="checkout-container">
        <div class="checkout-form">



            <form id="orderForm" action="{{ route('sendOrder', ['id' => $order->id]) }}" method="POST">

            @csrf
                <div class="form-grid">
                    <input type="tel" name="phone" id="phone" class="input-tel" placeholder="Телефон" required>
                    <input type="text" name="name" id="name" class="input-name" placeholder="Имя" required>
                    <input type="email" name="email" id="email" class="input-email" placeholder="E-mail" required>
                    <label class="checkbox-container">
                        <input type="checkbox" name="terms" id="callbackCheck">
                        <span class="checkmark"> Перезвоните мне для подтверждения заказа</span>
                    </label>
                    <div class="alert-container">
                        @if(session('message'))
                            <div class="alert-info">
                                {{ session('message') }}
                            </div>
                        @endif
                    </div>

                </div>
                <button type="submit" class="checkout-btn" role="button">
                    Оформить заказ
                </button>

            </form>


            <div class="delivery-section">
                    <h2>Способ получения</h2>
                    <div class="delivery-option">
                        <div class="delivery-header">
                            <div>
                                <span class="store-icon">🏪</span>
                                В магазине в любое время
                            </div>
                        </div>
                    </div>
                </div>

                <div class="payment-section">
                    <h2>Способ оплаты</h2>
                    <div class="payment-options">
                        <button type="button" class="payment-btn active">При получении</button>
                    </div>
                </div>

                <div class="confirmation">


                    <label class="checkbox-container">
                        <input type="checkbox" id="termsCheck" required>
                        <span class="checkmark">Я соглашаюсь с <a href="#">условиями оферты</a> и <a href="#">политикой конфиденциальности</a></span>
                    </label>
                </div>
            </form>
        </div>



        <div class="order-summary">
            <div class="product-info">
                <div class="product-details">
                    Сведения о товаре
                </div>
            </div>

            <div class="price-breakdown">
                <div class="price-row">
                    <div class="price-rowTextLeft">Товары&nbsp;</div>
                    <div class="price-rowTextRight">
                        @forelse($cart as $product)
                            <div class="price-rowText-inside">
                                {{ $product['product_name'] }} × {{ $product['count'] }} – {{ number_format(($product['price'] ?? 0) * $product['count'], 2, '.', ' ') }} ₽
                            </div>
                        @empty
                            <div class="price-rowText-inside">Корзина пуста</div>
                        @endforelse
                    </div>
                </div>

                <div class="price-row discount">
                    <span>Скидка:</span>
                    <span>{{ number_format($discount ?? 0, 2, '.', ' ') }} ₽</span>
                </div>

                <div class="price-row total">
                    <span>К оплате:</span>
                    <span>{{ number_format($finalPrice ?? 0, 2, '.', ' ') }} ₽</span>
                </div>
            </div>

        </div>




        <div class="terms-warning-message" style="display:none; color: #ff0000;">
                Убедитесь, что заполнены все контактные данные и выбран способ доставки
            </div>
        </div>
    </div>

    <script>
        document.getElementById('orderForm').addEventListener('submit', function(event) {
            let termsCheck = document.getElementById('termsCheck');
            if (!termsCheck.checked) {
                event.preventDefault();
                alert('Чтобы продолжить, установите флажок "Я соглашаюсь с условиями оферты и политикой конфиденциальности".');
            }
        });
    </script>
@endsection
