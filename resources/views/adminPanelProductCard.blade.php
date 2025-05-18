@extends('master')

@php use Illuminate\Support\Facades\Vite; @endphp

@section('title', 'Редактирование: ' . $product->product_name)

@section('content')

    <div class="cartProductTitle-container">
        <div class="cartProduct-Title">Редактирование товара</div>
    </div>

    <div class="cartProduct-container">
        <form action="{{ route('products.update', $product->id) }}"
              class="formInsertProduct"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Вывод ошибок -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="InsertBlock">
                <input class="inputInsert @error('product_name') is-invalid @enderror" type="text" name="product_name"
                       value="{{ old('product_name', $product->product_name) }}" placeholder="Наименование товара" required>
                <input class="inputInsert @error('product_price') is-invalid @enderror" type="text" name="product_price"
                       value="{{ old('product_price', $product->product_price) }}" placeholder="Цена" required>
            </div>

            <div class="InsertBlock">
                <input class="inputInsert @error('product_color') is-invalid @enderror" type="text" name="product_color"
                       value="{{ old('product_color', $product->product_color) }}" placeholder="Цвет товара" required>
                <input class="inputInsert @error('product_memory') is-invalid @enderror" type="text" name="product_memory"
                       value="{{ old('product_memory', $product->product_memory) }}" placeholder="Память (если имеется)" required>
            </div>

            <div class="InsertBlock">
                <label for="main_image" class="custom-file-upload">Заменить основное изображение</label>
                <input type="file" name="main_image" id="main_image" accept="image/*" onchange="previewMainImage(this)">
                <div id="mainImagePreview" style="margin-top: 10px;">
                    @if($product->main_image)
                        <img src="{{ asset('img/catalog/' . $product->main_image) }}" alt="Текущее основное изображение"
                             style="width: 150px; height: 150px;">
                    @else
                        <p>Нет основного изображения</p>
                    @endif
                </div>
            </div>

            <div class="InsertBlock">
                <label for="product_images" class="custom-file-upload">Дополнительные изображения</label>
                <input type="file" name="product_images[]" id="product_images" accept="image/*" multiple onchange="previewImages(this)">
                <div id="imagePreview" style="margin-top: 10px;">
                    @foreach(json_decode($product->product_images, true) ?? [] as $img)
                        <img src="{{ asset('img/catalog/' . $img) }}" alt="Изображение"
                             style="width: 150px; height: 150px; margin-right: 5px;" >
                    @endforeach
                </div>
            </div>

            <div class="InsertBlock">
                <select class="inputInsert @error('categories_id') is-invalid @enderror" name="categories_id" required>
                    <option value="">Выберите категорию</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                        @if(old('categories_id'))
                            {{ old('categories_id') == $category->id ? 'selected' : '' }}
                            @else
                            {{ (isset($product) && $product->categories_id == $category->id) ? 'selected' : '' }}
                            @endif
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

            </div>

            <div class="InsertBlock1">
                <textarea name="product_description" class="inputInsert @error('product_description') is-invalid @enderror" required>{{ old('product_description', $product->product_description) }}</textarea>
                @error('product_description') <div class="invalid-feedback">{{ $message }}</div> @enderror

                <div class="availabilityChecked">
                    <span>В наличии?</span>
                    <input type="checkbox" class="checkedAvailability" name="availability" value="1"
                        {{ old('availability', $product->availability) ? 'checked' : '' }}>
                </div>
            </div>

            <button type="submit" class="SaveInsert">Сохранить</button>
        </form>
    </div>

    <script>
        function previewMainImage(input) {
            const preview = document.getElementById('mainImagePreview');
            preview.innerHTML = '';
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '150px';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewImages(input) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            const files = input.files;
            // Проверка, выбрано ли хотя бы 4 изображения
            if (files.length < 4) {
                alert('Пожалуйста, выберите минимум 4 изображения.');
            }

            if (files) {
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = e => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '100px';
                        img.style.marginRight = '5px';
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }

        // Проверка при отправке формы
        document.querySelector('.formInsertProduct').addEventListener('submit', function(e) {
            const additionalImagesInput = document.getElementById('product_images');
            const files = additionalImagesInput.files;

            if (files.length < 4) {
                e.preventDefault(); // Останавливаем отправку формы
                alert('Пожалуйста, выберите минимум 4 изображения для товара.');
            }
        });

    </script>

@endsection
