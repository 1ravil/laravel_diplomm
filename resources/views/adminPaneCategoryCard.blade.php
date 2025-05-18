@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp
@section('title', 'Редактирование: ' . $categories->name)
@section('content')

    <div class="cartProductTitle-container">
        <div class="cartProduct-Title">Редактирование категории</div>
    </div>

    <div class="cartProduct-container">
        <form id="editCategoryForm" action="{{ route('CategoriesUpdate', $categories->id) }}" class="formInsertProduct" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
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
                <input class="inputInsert" type="text" name="categories_name" value="{{ $categories->name }}" placeholder="Наименование категории" required>
                <label for="product_img" class="custom-file-upload">
                    {{ !empty($categories->img) ? 'Выберите файл, чтобы поменять изображение' : 'Выберите файл, чтобы добавить изображение' }}
                </label>
            </div>

            <div class="InsertBlock2">
                <input id="product_img" type="file" name="product_img" accept="image/*">
                <div id="productImagePreview" style="margin-top: 10px; margin-bottom: 50px"></div>
            </div>

            <button type="submit" class="SaveInsert">Сохранить</button>
        </form>
    </div>

    {{-- JS для превью и валидации --}}
    <script>
        const fileInput = document.getElementById('product_img');
        const preview = document.getElementById('productImagePreview');

        fileInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            preview.innerHTML = '';

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '200px';
                    img.style.marginTop = '10px';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('editCategoryForm').addEventListener('submit', function (e) {
            // Пример простой проверки: если изображение не выбрано и раньше его не было, покажем предупреждение
            const imageWasEmpty = @json(empty($categories->img));
            const file = fileInput.files[0];

            if (imageWasEmpty && !file) {
                alert('Пожалуйста, выберите изображение для категории.');
                fileInput.focus();
                e.preventDefault();
            }
        });
    </script>

@endsection
