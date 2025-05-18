@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp
@section('title', 'Добавление товара')
@section('content')

    <div class="cartProductTitle-container">
        <div class="cartProduct-Title">Добавление новой категории</div>
    </div>

    <div class="cartProduct-container">
        <form id="categoryForm" action="{{ route('adminPanelCategoryStore') }}" class="formInsertProduct" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
                <div class="alert alert-dangerProductStore">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="InsertBlock">
                <input class="inputInsert" type="text" name="categories_name" placeholder="Наименование категории" required>

                <input id="categories_img" type="file" name="categories_img" accept="image/*">

                <div id="categoryImagePreview" style="margin-top: 10px; margin-bottom: 50px;"></div>

                <label for="categories_img" class="custom-file-upload">
                    Выберите файл для изображения категории
                </label>
            </div>

            <button type="submit" class="SaveInsert">Добавить</button>
        </form>

    </div>

    <script>
        // Превью изображения категории
        document.getElementById('categories_img').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('categoryImagePreview');
            previewContainer.innerHTML = '';

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '200px';
                    img.style.marginTop = '10px';
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });

        // Валидация перед отправкой формы
        document.getElementById('categoryForm').addEventListener('submit', function(e) {
            const imageInput = document.getElementById('categories_img');
            if (!imageInput.files || imageInput.files.length === 0) {
                alert('Пожалуйста, загрузите изображение категории.');
                imageInput.focus();
                e.preventDefault();
            }
        });
    </script>

@endsection
