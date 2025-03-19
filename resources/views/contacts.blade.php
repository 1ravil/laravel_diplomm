@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp

@section('content')

<footer>
    <div class="contacts-container">
        <div class="contacts-title">
            Контакты
        </div>
</footer>


<div class="maps-container">


    <div class="maps-text">
        <div class="mapsText-left">
            <div class="mapsText-left1">
                Адрес<br>
                улица Ленина, 100, Уфа,<br> Республика Башкортостан
            </div>
            <div class="mapsText-left2">
                Телефон <br>
                8 (927) 929-29-17
            </div>
        </div>
        <div class="mapsText-right">
            <div class="mapsText-right1">
                Режим работы <br>
                Ежедневно с 10:00-22:00
            </div>
            <div class="mapsText-right2">
                Email <br>
                RavilIbakov102@yandex.ru
            </div>
        </div>
    </div>

    <div class="maps">
        <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Ab4faaf433d5f157672926a856b59f32bba2f023971d27812d11d2945938129cf&amp;width=754&amp;height=677&amp;lang=ru_RU&amp;scroll=true"></script>
    </div>

</div>


<div class="legal_information">
    <div class="lin_container">
        <div class="lin-titleContainer">
            <div class="lin-title">
                Юридическая информация
            </div>
        </div>
    </div>
    <div class="lin-infoContainer">
        <div class="lin-info">
            Наименование организации: ИП Ибаков Равиль Фидратович<br>
            Юридический и почтовый адрес: Уфа, ул. Ленина, 100, 450006<br>
            ИНН: 020404087928<br>
            БИК: 044525411234<br>
            РС: 40802810116050001425<br>
            КС: 30101810145250000411<br>
        </div>
    </div>
</div>
</div>


<footer>
    <div class="footer-container">
        <div class="footer-text">
            Сайт носит сугубо информационный характер и не является публичной офертой, определяемой Статьей 437 (2) ГК РФ. Apple, логотип Apple и изображения Apple являются зарегистрированными товарными знаками компании Apple Inc. в США и других странах. App Store является знаком обслуживания компании Apple Inc. Instagram принадлежит компании Meta, признанной экстремистской организацией и запрещенной в РФ.
        </div>
    </div>
</footer>

</body>
</html>

@endsection
