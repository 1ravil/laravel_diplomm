@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp
@section('title', 'Все категории')
@section('content')

<div class="title-container_Category">
   <div class="title-text_Category">
       Категории
   </div>
</div>

@foreach($categories as $categories1)
    @include('cardCategories', compact('categories'))
@endforeach

<footer>
    <div class="footer-container1">
        <div class="footer-text1">
            Сайт носит сугубо информационный характер и не является публичной офертой, определяемой Статьей 437 (2) ГК РФ. Apple, логотип Apple и изображения Apple являются зарегистрированными товарными знаками компании Apple Inc. в США и других странах. App Store является знаком обслуживания компании Apple Inc. Instagram принадлежит компании Meta, признанной экстремистской организацией и запрещенной в РФ.
        </div>
    </div>
</footer>

@endsection
