@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp

@section('content')




<div class="image">
    <div class="image-container">
        <img class="image-1" src="{{ Vite::asset('resources/img/installment/installment.png') }}" alt="">
    </div>
</div>

<div class="creditTitle-container">
    <div class="credit-title">
        Доступные банки
    </div>
</div>



<div class="credit">
    <div class="credit-container">
        <div class="credit-box">
            <div class="credit-info1">Сбербанк</div>
            <div class="credit-info1">Тинькофф</div>
            <div class="credit-info1">МТС Банк</div>
        </div>
    </div>
</div>


<div class="creditTitle-container">
    <div class="credit-title">
        Основные требования
    </div>
</div>


<div class="credit">
    <div class="credit-container1">
        <div class="credit-box">
            <div class="credit-info1">Гражданство РФ</div>
            <div class="credit-info1">
                Возраст<br>
                от 18 до 70 лет
            </div>
            <div class="credit-info1">Наличие постоянной регистрации <br>на территории РФ</div>
        </div>
    </div>
</div>






<latest-episode>
    <div class="title-container1">
        <div class="latest-title">
            Виды сервисов кредитных продуктов
        </div>
    </div>
</latest-episode>




<cards>
    <div class="card-container">
        <div class="cards-holder">
            <div class="card">
                <div class="card-left">
                    <div class="card-image">
                        <img class="card-image1" src="{{ Vite::asset('resources/img/installment/pokupay_logo.png') }}">
                    </div>
                </div>
                <div class="card-right">
                    <div class="card-title">
                        Кредит по программе "Покупай со Сбером"
                    </div>
                    <div class="card-subtitle">
                        Преимущества Сервиса: <br>

                        1) Без первоначального взноса по кредиту <br>
                        2) Рассрочка предоставляются на срок 6, 9, 10, 12, 18, 24, 36 месяцев <br>
                        3) Кредит предоставляется на срок 6, 9, 10, 12, 18, 24, 36 месяцев <br>
                        4) Сумма кредита от 3 000 до 300 000 рублей
                    </div>
                </div>
            </div>
        </div>

        <div class="cards-holder">
            <div class="card">
                <div class="card-left">
                    <div class="card-image">
                        <img class="card-image" src="{{ Vite::asset('resources/img/installment/Poscredit_log.png') }}">
                    </div>
                </div>
                <div class="card-right">
                    <div class="card-title">
                        POSCREDIT - Несколько банков-партнеров одновременно.
                    </div>
                    <div class="card-subtitle">
                        Преимущества сервиса: <br>

                        1) Онлайн решение за пару минут<br>
                        2) Отправка сразу в несколько банков<br>
                        3) Для оформления нужен только паспорт
                    </div>
                </div>
            </div>


        </div>
    </div>







    <latest-episode>
        <div class="title-container1">
            <div class="latest-title">
                Как оформить рассрочку дистанционно?
            </div>
        </div>
    </latest-episode>




    <cards>
        <div class="card-container">


            <div class="cards-holder1">
                <div class="card-right">
                    <div class="card-title1">
                        Кредит по программе "Покупай со Сбером"
                    </div>
                    <div class="card-subtitle1">
                        1) Выберите товары на сайте и добавьте их в корзину, нажмите «Купить в рассрочку», дождитесь подтверждения заказа. <br>
                        2) По полученной ссылке перейдите в СберБанк Онлайн, авторизуйтесь и заполните заявку. Рассмотрение заявки займет несколько минут <br>
                        3) Если рассрочка одобрена, подтвердите согласие с её условиями в СберБанк Онлайн <br>
                        4) Согласуйте с магазином комфортный способ и время получения заказа
                    </div>
                </div>
            </div>


            <div class="cards-holder1">
                <div class="card-right">
                    <div class="card-title1">
                        POSCREDIT - Несколько банков-партнеров одновременно.
                    </div>
                    <div class="card-subtitle1">
                        1) Добавьте товары в корзину <br>
                        2) Нажмите «Купить в рассрочку»<br>
                        3) Заполните форму и завершите оформление заказа<br>
                        4) Наши сотрудники свяжутся с вами для подтверждения заказа, после чего Вам будет направлена ссылка для оформления рассрочки онлайн
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </cards>





    <div class="footer-container1">
        <div class="footer-text1">
            Сайт носит сугубо информационный характер и не является публичной офертой, определяемой Статьей 437 (2) ГК РФ. Apple, логотип Apple и изображения Apple являются зарегистрированными товарными знаками компании Apple Inc. в США и других странах. App Store является знаком обслуживания компании Apple Inc. Instagram принадлежит компании Meta, признанной экстремистской организацией и запрещенной в РФ.
        </div>
    </div>


</body>
</html>

@endsection
