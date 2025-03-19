@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp

@section('title', 'Категория: '. $category->name )

@section('content')

    <div class="title-container_Catalog">
        <div class="title-text_Catalog">
            Каталог
        </div>
    </div>

    <div class="CatalogContainer">
        <!-- Filters Sidebar -->
        <aside class="CatalogFilters">
            <div class="CatalogFilters-header">
                <h3>ФИЛЬТР</h3>
                <button class="CatalogFilters-clear" onclick="resetFilters()">Сбросить</button>
            </div>

            <form action="{{ route('categoriesByPhone', $category->id) }}" method="GET">
                <!-- Фильтр по памяти -->
                @if($uniqueMemory && count($uniqueMemory) > 0)
                    <div class="CatalogFilters-group">
                        <h4>Память</h4>
                        @foreach($uniqueMemory as $memory => $count)
                            @if($memory && $count > 0)
                                <label class="CatalogFilters-option">
                                    <input type="checkbox" name="memory[]" value="{{ $memory }}" {{ in_array($memory, request('memory', [])) ? 'checked' : '' }}>
                                    <span>{{ $memory }} ГБ ({{ $count }})</span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                @endif

                <!-- Фильтр по модели -->
                @if($uniqueModels && count($uniqueModels) > 0)
                    <div class="CatalogFilters-group">
                        <h4>Модель</h4>
                        @foreach($uniqueModels as $model => $count)
                            @if($model && $count > 0)
                                <label class="CatalogFilters-option">
                                    <input type="checkbox" name="model[]" value="{{ $model }}" {{ in_array($model, request('model', [])) ? 'checked' : '' }}>
                                    <span>{{ $model }} ({{ $count }})</span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                @endif

                <!-- Фильтр по цвету -->
                @if($uniqueColors && count($uniqueColors) > 0)
                    <div class="CatalogFilters-group">
                        <h4>Цвет</h4>
                        @foreach($uniqueColors as $color => $count)
                            @if($color && $count > 0)
                                <label class="CatalogFilters-option">
                                    <input type="checkbox" name="color[]" value="{{ $color }}" {{ in_array($color, request('color', [])) ? 'checked' : '' }}>
                                    <span>{{ $color }} ({{ $count }})</span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                @endif

                <!-- Кнопка "Применить" -->
                <div class="CatalogButtonContainer">
                    <button type="submit" class="CatalogFilters-apply">Применить</button>
                </div>
            </form>
        </aside>

        <!-- Main Content -->
        <main class="CatalogContent">
            <div class="CatalogContent-header">
                <div class="CatalogSort-container">
                    <form action="{{ route('categoriesByPhone', $category->id) }}" method="GET" id="sortForm">
                        <select name="sort" id="sortSelect" class="CatalogSort-select" onchange="document.getElementById('sortForm').submit()">
                            <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>По умолчанию (убывание)</option>
                            <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>По цене (возрастание)</option>
                            <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>По цене (убывание)</option>
                            <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>По названию (А-Я)</option>
                            <option value="name-desc" {{ request('sort') == 'name-desc' ? 'selected' : '' }}>По названию (Я-А)</option>
                        </select>
                    </form>
                </div>
                <div class="CatalogContentContainer">
                    <div class="CatalogContentCategoryName">
                        {{$category->name}}
                    </div>
                </div>
            </div>

            <div class="container_Catalog">
                <div class="container__cards_Catalog" style="{{ $products->isEmpty() ? 'display: block;' : 'display: grid;' }}">
                    @forelse($products as $product)
                        @include('card', compact('product'))
                    @empty
                        <div class="notFoundCatalogContainer">
                            <p>Ничего не найдено по вашему запросу.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    <script>
        function resetFilters() {
            window.location.href = "{{ route('categoriesByPhone', $category->id) }}";
        }
    </script>
@endsection
