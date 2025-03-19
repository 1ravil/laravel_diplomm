@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp

@section('content')

<div class="title-container">
   <div class="title-text">
       Каталог
   </div>
</div>


<div class="container">
   <div class="container__cards">
       <div class="card">
           <!-- Верхняя часть -->
           <div class="card__top">
               <!-- Изображение-ссылка товара -->
               <a href="#" class="card__image">
                   <img
                       src="{{ Vite::asset('resources/img/catalog/iphone14.png') }}"
                       alt="Apple IPhone 14"
                   />
               </a>
               <!-- Скидка на товар -->
               <div class="card__label">-10%</div>
           </div>
           <!-- Нижняя часть -->
           <div class="card__bottom">
               <!-- Цены на товар (с учетом скидки и без)-->
               <div class="card__prices">
                   <div class="card__price card__price--discount">135 000</div>
                   <div class="card__price card__price--common">150 000</div>
               </div>
               <!-- Ссылка-название товара -->
               <a href="#" class="card__title">
                   Смартфон Apple IPhone 14 Pro Max 256Gb, золотой
               </a>
               <!-- Кнопка добавить в корзину -->
               <button type="button" class="card__add buy-button js-buy-button">В корзину</button>
           </div>
       </div>



       <div class="card">
           <!-- Верхняя часть -->
           <div class="card__top">
               <!-- Изображение-ссылка товара -->
               <a href="#" class="card__image">
                   <img
                       src="{{ Vite::asset('resources/img/catalog/iphone14.png') }}"
                       alt="Apple IPhone 14"
                   />
               </a>
               <!-- Скидка на товар -->
               <div class="card__label">-10%</div>
           </div>
           <!-- Нижняя часть -->
           <div class="card__bottom">
               <!-- Цены на товар (с учетом скидки и без)-->
               <div class="card__prices">
                   <div class="card__price card__price--discount">135 000</div>
                   <div class="card__price card__price--common">150 000</div>
               </div>
               <!-- Ссылка-название товара -->
               <a href="#" class="card__title">
                   Смартфон Apple IPhone 14 Pro Max 256Gb, золотой
               </a>
               <!-- Кнопка добавить в корзину -->
               <button class="card__add">В корзину</button>
           </div>
       </div>



       <div class="card">
           <!-- Верхняя часть -->
           <div class="card__top">
               <!-- Изображение-ссылка товара -->
               <a href="#" class="card__image">
                   <img
                       src="{{ Vite::asset('resources/img/catalog/iphone14.png') }}"
                       alt="Apple IPhone 14"
                   />
               </a>
               <!-- Скидка на товар -->
               <div class="card__label">-10%</div>
           </div>
           <!-- Нижняя часть -->
           <div class="card__bottom">
               <!-- Цены на товар (с учетом скидки и без)-->
               <div class="card__prices">
                   <div class="card__price card__price--discount">135 000</div>
                   <div class="card__price card__price--common">150 000</div>
               </div>
               <!-- Ссылка-название товара -->
               <a href="#" class="card__title">
                   Смартфон Apple IPhone 14 Pro Max 256Gb, золотой
               </a>
               <!-- Кнопка добавить в корзину -->
               <button class="card__add">В корзину</button>
           </div>
       </div>

       <div class="card">
           <!-- Верхняя часть -->
           <div class="card__top">
               <!-- Изображение-ссылка товара -->
               <a href="#" class="card__image">
                   <img
                       src="{{ Vite::asset('resources/img/catalog/iphone14.png') }}"
                       alt="Apple IPhone 14"
                   />
               </a>
               <!-- Скидка на товар -->
               <div class="card__label">-10%</div>
           </div>
           <!-- Нижняя часть -->
           <div class="card__bottom">
               <!-- Цены на товар (с учетом скидки и без)-->
               <div class="card__prices">
                   <div class="card__price card__price--discount">135 000</div>
                   <div class="card__price card__price--common">150 000</div>
               </div>
               <!-- Ссылка-название товара -->
               <a href="#" class="card__title">
                   Смартфон Apple IPhone 14 Pro Max 256Gb, золотой
               </a>
               <!-- Кнопка добавить в корзину -->
               <button class="card__add">В корзину</button>
           </div>
       </div>

       <div class="card">
           <!-- Верхняя часть -->
           <div class="card__top">
               <!-- Изображение-ссылка товара -->
               <a href="#" class="card__image">
                   <img
                       src="{{ Vite::asset('resources/img/catalog/iphone14.png') }}"
                       alt="Apple IPhone 14"
                   />
               </a>
               <!-- Скидка на товар -->
               <div class="card__label">-10%</div>
           </div>
           <!-- Нижняя часть -->
           <div class="card__bottom">
               <!-- Цены на товар (с учетом скидки и без)-->
               <div class="card__prices">
                   <div class="card__price card__price--discount">135 000</div>
                   <div class="card__price card__price--common">150 000</div>
               </div>
               <!-- Ссылка-название товара -->
               <a href="#" class="card__title">
                   Смартфон Apple IPhone 14 Pro Max 256Gb, золотой
               </a>
               <!-- Кнопка добавить в корзину -->
               <button class="card__add">В корзину</button>
           </div>
       </div>
       <div class="card">
           <!-- Верхняя часть -->
           <div class="card__top">
               <!-- Изображение-ссылка товара -->
               <a href="#" class="card__image">
                   <img
                       src="{{ Vite::asset('resources/img/catalog/iphone14.png') }}"
                       alt="Apple IPhone 14"
                   />
               </a>
               <!-- Скидка на товар -->
               <div class="card__label">-10%</div>
           </div>
           <!-- Нижняя часть -->
           <div class="card__bottom">
               <!-- Цены на товар (с учетом скидки и без)-->
               <div class="card__prices">
                   <div class="card__price card__price--discount">135 000</div>
                   <div class="card__price card__price--common">150 000</div>
               </div>
               <!-- Ссылка-название товара -->
               <a href="#" class="card__title">
                   Смартфон Apple IPhone 14 Pro Max 256Gb, золотой
               </a>
               <!-- Кнопка добавить в корзину -->
               <button class="card__add">В корзину</button>
           </div>
       </div>
       <div class="card">
           <!-- Верхняя часть -->
           <div class="card__top">
               <!-- Изображение-ссылка товара -->
               <a href="#" class="card__image">
                   <img
                       src="{{ Vite::asset('resources/img/catalog/iphone14.png') }}"
                       alt="Apple IPhone 14"
                   />
               </a>
               <!-- Скидка на товар -->
               <div class="card__label">-10%</div>
           </div>
           <!-- Нижняя часть -->
           <div class="card__bottom">
               <!-- Цены на товар (с учетом скидки и без)-->
               <div class="card__prices">
                   <div class="card__price card__price--discount">135 000</div>
                   <div class="card__price card__price--common">150 000</div>
               </div>
               <!-- Ссылка-название товара -->
               <a href="#" class="card__title">
                   Смартфон Apple IPhone 14 Pro Max 256Gb, золотой
               </a>
               <!-- Кнопка добавить в корзину -->
               <button class="card__add">В корзину</button>
           </div>
       </div>
       <div class="card">
           <!-- Верхняя часть -->
           <div class="card__top">
               <!-- Изображение-ссылка товара -->
               <a href="#" class="card__image">
                   <img
                       src="{{ Vite::asset('resources/img/catalog/iphone14.png') }}"
                       alt="Apple IPhone 14"
                   />
               </a>
               <!-- Скидка на товар -->
               <div class="card__label">-10%</div>
           </div>
           <!-- Нижняя часть -->
           <div class="card__bottom">
               <!-- Цены на товар (с учетом скидки и без)-->
               <div class="card__prices">
                   <div class="card__price card__price--discount">135 000</div>
                   <div class="card__price card__price--common">150 000</div>
               </div>
               <!-- Ссылка-название товара -->
               <a href="#" class="card__title">
                   Смартфон Apple IPhone 14 Pro Max 256Gb, золотой
               </a>
               <!-- Кнопка добавить в корзину -->
               <button class="card__add">В корзину</button>
           </div>
       </div>


   </div>

</div>


@endsection
