@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp

@section('content')

<footer>
    <div class="container">
        <div class="header-left">
            <div class="img">
                <img class="image-1" src="{{ Vite::asset('resources/img/index/iphone16.png') }}" alt="">
            </div>
        </div>

        <div class="header-right">
            <div class="right-title">
                <div class="right-tobject">
                    Откройте мир инноваций с Apple: технологии, которые меняют жизнь!
                    <!--  <img class="next-img" src="next.png"> <span>level</span> -->
                </div>
            </div>
            <div class="right-href">
                <div class="rh-title">Узнать больше</div>
                <div class="href-img">
                    <a href="#" class="href-img1"><img src="{{ Vite::asset('resources/img/index/avito.png') }}" alt=""></a>
                    <a href="#" class="href-img1"><img src="{{ Vite::asset('resources/img/index/instagram.png') }}" alt=""></a>
                    <!-- <a href="#" class="href-img1"><img src="image-href/3.png" alt=""></a>
                    <a href="#" class="href-img1"><img src="image-href/4.png" alt=""></a>
                    <a href="#" class="href-img1"><img src="image-href/5.png" alt=""></a> -->
                </div>
            </div>
        </div>
    </div>
</footer>


<latest-episode>
    <div class="title-container">
        <div class="latest-title">
            Частые вопросы
        </div>
    </div>
</latest-episode>


<cards>
    <div class="card-container">
        <div class="cards-holder">
            <div class="card">
                <div class="card-left">
                    <div class="card-image">
                        <img class="card-image" src="{{ Vite::asset('resources/img/index/check_the_equipment.png') }}">
                    </div>
                </div>
                <div class="card-right">
                    <div class="card-title">
                        Можно ли проверить технику перед покупкой?
                    </div>
                    <div class="card-subtitle">
                        Перед покупкой можно проверить технику любыми способами, и мы Вам в этом можем помочь. Самый
                        надежный способ проверки телефона на официальном сайте apple.com в разделе «Проверка права на
                        сервисное обслуживание»: https://checkcoverage.apple.com/?locale=ru_RU. Также проверить технику
                        можно, позвонив на горячую линию службы поддержки Apple по бесплатному номеру 8 800 333 51 73 и
                        продиктовав им IMEI либо серийный номер нового телефона.
                    </div>
                </div>
            </div>
        </div>

        <div class="cards-holder">
            <div class="card">
                <div class="card-left">
                    <div class="card-image">
                        <img class="card-image" src="{{ Vite::asset('resources/img/index/original_technique.png') }}" alt="">
                    </div>
                </div>
                <div class="card-right">
                    <div class="card-title">
                        А у вас техника оригинальная?
                    </div>
                    <div class="card-subtitle">
                        Вся техника, которая продается в нашем магазине оригинальная с официальной гарантией от Apple.
                        Проверить на оригинальность легко на официальном сайте Apple или позвонить по бесплатному номеру
                        на горячую линию и продиктовать серийный номер телефона.
                    </div>
                </div>
            </div>
        </div>

        <div class="cards-holder">
            <div class="card">
                <div class="card-left">
                    <div class="card-image">
                        <img class="card-image" src="{{ Vite::asset('resources/img/index/garanty.jpg') }}">
                    </div>
                </div>
                <div class="card-right">
                    <div class="card-title">
                        Есть ли гарантия на технику?
                    </div>
                    <div class="card-subtitle">
                        На всю технику Apple в нашем магазине действует официальная гарантия 1 год, которая начинается с
                        момента активации телефона.
                    </div>
                </div>
            </div>
        </div>
    </div>
</cards>
<subscribe>
    <div class="subscride-container">
        <div class="subscride-holder">
            <div class="subscribe-left">
                <div class="subscribe-title">Узнавай о всех поступлениях первым!</div>
                <div class="subscribe-subtitle">Подписаться на <br>обновления</div>
            </div>
            <div class="subscride-right">
                <div class="subscride-form">
                    <div class="form-field">
                        <input type="text" class="i-1" placeholder="Имя">
                    </div>
                    <div class="form-field">
                        <input type="text" class="i-2" placeholder="Электронная почта">
                    </div>
                </div>
                <div class="subscribe-button">
                    <button name="cars-sbscrdbutton" class="card-sbscrd" id="open-modal-btn">Подписаться</button>
                </div>
            </div>

            <div class="modal" id="my-modal">
                <div class="modal_box">
                    <button class="modal_close-btn" id="close-my-model-btn">Закрыть</button>
                    <div class="user-list">Ваши данные</div>
                    <div class="user-subtitle">
                        <p id="name1"></p>
                        <p id="email1"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</subscribe>

<div class="reviews-container1">
    <div class="reviews-title1">
        Наши отзывы
    </div>
</div>

<reviews>
    <div class="reviews-container">
        <div class="left">
            <div class="reviews-holder">
                <div class="holder-container">
                    <div class="stars-images">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                    </div>
                    <div class="reviews-title">
                        Рекомендую! <br> Товар как в описании.
                    </div>
                    <div class="reviews-subtitle">
                        Сергей Измайлов
                    </div>
                </div>
            </div>

            <div class="reviews-holder">
                <div class="holder-container">
                    <div class="stars-images">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                    </div>
                    <div class="reviews-title">
                        Забрала телефон, все при мне показал.<br> Телефон в идеале.
                    </div>
                    <div class="reviews-subtitle">
                        Валентина Петрова
                    </div>
                </div>

            </div>

        </div>

        <div class="center">

            <div class="reviews-holder">
                <div class="holder-container">
                    <div class="stars-images">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                    </div>
                    <div class="reviews-title">
                        Спасибо, вошел в положение. <br>Телефоном доволен!
                    </div>
                    <div class="reviews-subtitle">
                        Антон Небов
                    </div>
                </div>
            </div>

            <div class="reviews-holder">
                <div class="holder-container">
                    <div class="stars-images">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                    </div>
                    <div class="reviews-title">
                        Все прошло отлично! Спасибо огромное!
                    </div>
                    <div class="reviews-subtitle">
                        Дмитрий Савин
                    </div>
                </div>
            </div>
        </div>

        <div class="right">
            <div class="reviews-holder">
                <div class="holder-container">
                    <div class="stars-images">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                    </div>
                    <div class="reviews-title">
                        Отличное обслуживание, сделали скидку!
                    </div>
                    <div class="reviews-subtitle">
                        Андрей Овечкин
                    </div>
                </div>
            </div>

            <div class="reviews-holder">
                <div class="holder-container">
                    <div class="stars-images">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                        <img class="stars" src="{{ Vite::asset('resources/img/index/stars.png') }}" alt="">
                    </div>
                    <div class="reviews-title">
                        Товар доставили быстро!<br> Магазин отличный!
                    </div>
                    <div class="reviews-subtitle">
                        Рустам Гизатуллин
                    </div>
                </div>
            </div>
        </div>

    </div>
</reviews>


<div class="catalogbtn-container">
    <div class="catalog-button">
        <button name="catalog-button" class="catalog-btn" onclick="location.href='{{ route('catalog') }}'">Перейти в каталог
        </button>
    </div>
</div>


<footer>
    <div class="footer-container">
        <div class="footer-text">
            Сайт носит сугубо информационный характер и не является публичной офертой, определяемой Статьей 437 (2) ГК
            РФ. Apple, логотип Apple и изображения Apple являются зарегистрированными товарными знаками компании Apple
            Inc. в США и других странах. App Store является знаком обслуживания компании Apple Inc. Instagram
            принадлежит компании Meta, признанной экстремистской организацией и запрещенной в РФ.
        </div>
    </div>
</footer>


<input oninput="onInput(this)">

@vite('resources/js/scriptIndex.js')
</body>
</html>

@endsection
