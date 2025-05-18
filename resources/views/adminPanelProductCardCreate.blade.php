@extends('master')

@php use Illuminate\Support\Facades\Vite; @endphp

@section('title', 'Добавление товара')

@section('content')

    <div class="cartProductTitle-container">
        <div class="cartProduct-Title">Добавление нового товара</div>
    </div>

    <div class="cartProduct-container">
        <form id="productForm" action="{{ route('adminPanelProductStore') }}" class="formInsertProduct" method="POST" enctype="multipart/form-data">
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
                <input class="inputInsert @error('product_name') is-invalid @enderror" type="text" name="product_name" placeholder="Наименование товара" value="{{ old('product_name') }}" required>
                <input class="inputInsert @error('product_price') is-invalid @enderror" type="text" name="product_price" placeholder="Цена" value="{{ old('product_price') }}" required>
            </div>

            <div class="InsertBlock">
                <input class="inputInsert @error('product_color') is-invalid @enderror" type="text" name="product_color" placeholder="Цвет товара" value="{{ old('product_color') }}" required>
                <input class="inputInsert @error('product_memory') is-invalid @enderror" type="text" name="product_memory" placeholder="Память (если отсутствует — 0)" value="{{ old('product_memory') }}">
            </div>

            <div class="InsertBlock2">
                <div class="container_image-choice">
                    <div class="block1">
                        <label for="main_image">Основное изображение:</label>
                        <input type="file" name="main_image" id="main_image">
                        @error('main_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div id="mainImagePreview" class="mt-2"></div> <!-- Для предосмотра основного изображения -->
                    </div>

                    <div class="block2">
                        <label for="product_images">Дополнительные изображения</label>
                        <input type="file" name="product_images[]" id="product_images" multiple accept="image/*">
                        <div id="imagePreview" class="mt-2"></div>
                        @error('product_images') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="InsertBlock">
                <select class="inputInsert @error('categories_id') is-invalid @enderror" name="categories_id" required>
                    <option value="">-- Выберите категорию --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('categories_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('categories_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="InsertBlock1">
                <textarea name="product_description" class="inputInsert1 @error('product_description') is-invalid @enderror" placeholder="Описание товара" required>{{ old('product_description') }}</textarea>
                @error('product_description') <div class="invalid-feedback">{{ $message }}</div> @enderror

                <div class="availabilityChecked">
                    <span>В наличии?</span>
                    <input type="checkbox" class="checkedAvailability" name="availability" value="1" {{ old('availability', true) ? 'checked' : '' }}>
                </div>
            </div>

            <button type="submit" class="SaveInsert">Добавить</button>
        </form>
    </div>

    {{-- Превью + валидация на JS --}}
    <script>
        // Превью для дополнительного изображения
        document.getElementById('product_images').addEventListener('change', function(event) {
            const files = event.target.files;
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.innerHTML = '';

            if (files.length < 4) {
                alert('Пожалуйста, выберите минимум 4 изображения.');
            }

            for (let i = 0; i < files.length; i++) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100px';
                    img.style.marginRight = '10px';
                    imagePreview.appendChild(img);
                };
                reader.readAsDataURL(files[i]);
            }
        });

        // Превью для основного изображения
        document.getElementById('main_image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const mainImagePreview = document.getElementById('mainImagePreview');
            mainImagePreview.innerHTML = ''; // Очистить предосмотр перед добавлением нового изображения

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '200px'; // Устанавливаем размер изображения
                    img.style.marginTop = '10px';
                    mainImagePreview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('productForm').addEventListener('submit', function(e) {
            const mainImageInput = document.getElementById('main_image');
            const additionalImages = document.getElementById('product_images');
            let isValid = true;  // Флаг для проверки валидности

            // Проверяем, выбрано ли основное изображение
            if (!mainImageInput.files || mainImageInput.files.length === 0) {
                // Покажем ошибку и запретим отправку формы
                alert('Пожалуйста, загрузите основное изображение.');
                mainImageInput.focus();  // Переводим фокус на основной инпут
                isValid = false;  // Форма не будет отправлена
            }

            // Проверяем, выбрано ли минимум 4 дополнительных изображения
            if (!additionalImages.files || additionalImages.files.length < 4) {
                alert('Пожалуйста, загрузите минимум 4 дополнительных изображения.');
                additionalImages.focus();  // Переводим фокус на поле с дополнительными изображениями
                isValid = false;  // Форма не будет отправлена
            }

            // Если валидация не прошла, предотвратим отправку формы
            if (!isValid) {
                e.preventDefault();  // Останавливаем отправку формы
            }
        });



    </script>

@endsection
