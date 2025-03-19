@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp
@section('title', 'Добавление товара')
@section('content')

    <div class="cartProductTitle-container">
        <div class="cartProduct-Title">Добавление нового товара</div>
    </div>

    <div class="cartProduct-container">
        <form action="{{ route('adminPanelProductStore') }}" class="formInsertProduct" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="InsertBlock">
                <input class="inputInsert" type="text" name="product_name" placeholder="Наименование товара" required>
                <input class="inputInsert" type="text" name="product_price" placeholder="Цена" required>
            </div>

            <div class="InsertBlock">
                <input class="inputInsert" type="text" name="product_color" placeholder="Цвет товара" required>
                <input class="inputInsert" type="text" name="product_memory" placeholder="Память (если отсутствует - 0)" required>
            </div>

            <div class="InsertBlock">
                <label for="product_images" class="custom-file-upload">
                    Выберите минимум 4 файла для изображений товара
                </label>
                <input id="product_images" type="file" name="product_images[]" multiple required>
                <input class="inputInsert" type="text" name="categories_id" placeholder="Номер категории" required>
            </div>

            <div class="InsertBlock1">
                <textarea name="product_description" class="inputInsert1" placeholder="Описание товара" required></textarea>
                <div class="availabilityChecked">
                    <span>В наличии?</span>
                    <input type="checkbox" class="checkedAvailability" name="availability" value="1" checked>
                </div>
            </div>

            <button type="submit" class="SaveInsert">Добавить</button>
        </form>
    </div>
    @vite('resources/js/scriptAdminPanelProductCardCreate.js')

@endsection
