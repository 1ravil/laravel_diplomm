@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp
@section('title', 'Добавление товара')
@section('content')

    <div class="cartProductTitle-container">
        <div class="cartProduct-Title">Добавление новой категории</div>
    </div>

    <div class="cartProduct-container">
        <form action="{{ route('adminPanelCategoryStore') }}" class="formInsertProduct" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="InsertBlock">
                <input class="inputInsert" type="text" name="categories_name" placeholder="Наименование категории" required>
                <label for="categories_img" class="custom-file-upload">
                    Выберите файл для изображения товара
                </label>
                <input id="categories_img" type="file" name="categories_img" required>
            </div>

            <button type="submit" class="SaveInsert">Добавить</button>
        </form>
    </div>

@endsection
