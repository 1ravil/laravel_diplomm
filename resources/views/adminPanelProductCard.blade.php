@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp
@section('title', 'Редактирование: ' . $product->product_name)
@section('content')

    <div class="cartProductTitle-container">
        <div class="cartProduct-Title">Редактирование товара</div>
    </div>

    <div class="cartProduct-container">
        <form action="{{ route('products.update', $product->id) }}" class="formInsertProduct" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="InsertBlock">
                <input class="inputInsert" type="text" name="product_name" value="{{ $product->product_name }}" placeholder="Наименование товара" required>

                <input class="inputInsert" type="text" name="product_price" value="{{ $product->product_price }}" placeholder="Цена" required>

            </div>
            <div class="InsertBlock">
                <input class="inputInsert" type="text" name="product_color" value="{{ $product->product_color }}" placeholder="Цвет товара" required>

                <input class="inputInsert" type="text" name="product_memory" value="{{ $product->product_memory }}" placeholder="Память (если имеется)" required>

            </div>
            <div class="InsertBlock">
                <label for="product_img" class="custom-file-upload">
                    Выберите файл, чтобы поменять изображение
                </label>
                <input id="product_img" type="file" name="product_img">
                <input class="inputInsert" type="text" name="categories_id" value="{{ $product->categories_id }}" placeholder="Номер категории" required>


            </div>


            <div class="InsertBlock1">
                <textarea name="product_description" class="inputInsert" required>{{ $product->product_description }}</textarea>
                <div class="availabilityChecked">
                    <span>В наличии?</span>
                    <input type="checkbox" class="checkedAvailability" name="availability" value="1" {{ $product->availability ? 'checked' : '' }}>
                </div>
            </div>

            <button type="submit" class="SaveInsert">Сохранить</button>
        </form>

    </div>

@endsection
