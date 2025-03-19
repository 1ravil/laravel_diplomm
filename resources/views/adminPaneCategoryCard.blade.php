@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp
@section('title', 'Редактирование: ' . $categories->name)
@section('content')

    <div class="cartProductTitle-container">
        <div class="cartProduct-Title">Редактирование товара</div>
    </div>

    <div class="cartProduct-container">
        <form action="{{ route('CategoriesUpdate', $categories->id) }}" class="formInsertProduct" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="InsertBlock">
                <input class="inputInsert" type="text" name="categories_id" value="{{ $categories->id }}" placeholder="Номер категории" required>

                <input class="inputInsert" type="text" name="categories_name" value="{{ $categories->name }}" placeholder="Наименование категории" required>

            </div>
            <div class="InsertBlock">
                <label for="product_img" class="custom-file-upload">
                    @if (!empty($category->img))
                        Выберите файл, чтобы поменять изображение
                    @else
                        Выберите файл, чтобы добавить изображение
                    @endif
                </label>
                <input id="product_img" type="file" name="product_img">
            </div>

            <button type="submit" class="SaveInsert">Сохранить</button>
        </form>

    </div>

@endsection
