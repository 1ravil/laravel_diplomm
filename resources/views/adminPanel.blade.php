@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp

@section('content')

    <div class="adminpanelContainer">
        <div class="adminPanel">
            Панель администратора
        </div>
    </div>

<div class="adminPanelWrapperContainer">
    <div class="adminPanelWrapper">
        <!-- Sidebar -->
        <aside class="adminPanelSidebar">
            <div class="adminPanelSidebarHeader">
                <i class='bx bx-cart-alt'></i>
                <span>AppleMarket</span>
            </div>

            <nav class="adminPanelSidebarNav">
                <div class="adminPanelNavSection">
                    <div class="adminPanelNavHeader">НАВИГАЦИЯ</div>
                    <a href="#" class="adminPanelNavLink">
                        <i class='bx bx-grid-alt'></i>
                        <span>Панель управления</span>
                    </a>
                </div>

                <div class="adminPanelNavSection">
                    <div class="adminPanelNavHeader">КАТАЛОГ</div>
                    <a href="{{ route('adminPanel') }}"  class="adminPanelNavLink active">
                        <i class='bx bx-package'></i>
                        <span>Товары</span>
                    </a>
                    <a href="{{ route('adminPanelCategory') }}"  class="adminPanelNavLink">
                        <i class='bx bx-category'></i>
                        <span>Категории</span>
                    </a>
                </div>

                <div class="adminPanelNavSection">
                    <div class="adminPanelNavHeader">ПРОДАЖИ</div>
                    <a href="{{ route('adminPanelOrders') }}" class="adminPanelNavLink">
                        <i class='bx bx-shopping-bag'></i>
                        <span>Заказы</span>
                    </a>
                    <a href="{{ route('adminPanelCustomers') }}" class="adminPanelNavLink">
                        <i class='bx bx-group'></i>
                        <span>Клиенты</span>
                    </a>
                    <a href="{{ route('adminPanelUsers') }}" class="adminPanelNavLink">
                        <i class='bx bx-group'></i>
                        <span>Пользователи</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="adminPanelMainContent">
            <header class="adminPanelMainHeader">
                <div class="adminPanelHeaderLeft">
                    <button id="sidebarToggle" class="adminPanelSidebarToggle">
                        <i class='bx bx-menu'></i>
                    </button>
                    <h1>Товары</h1>
                </div>
                <div class="adminPanelHeaderRight">
                    <a href="{{ route('adminPanelProductCreate') }}" class="custom-btn">
                        <img src="{{ Vite::asset('resources/img/adminPanel/add.png') }}" alt="Добавить товар" class="icon-button">
                    </a>

                    <button id="filterToggleButton" class="custom-btn">Фильтр</button>
                    <span class="adminPanelUserName">{{auth()->user()->name}}</span>
                    <button class="adminPanelLogoutBtn">Выход</button>
                </div>
            </header>

            <div class="adminPanelContent">
                <div class="adminPanelContentCard">
                    <!-- Filters -->
                    <form id="filterForm" method="GET" action="{{ route('adminPanelFilter') }}">
                        <div id="filterPanel" class="adminPanelFilters" style="display: none;">
                            <div class="adminPanelFilterGrid">
                            <div class="adminPanelFilterItem">
                                <label>Наименование товара:</label>
                                <input type="text" name="name" class="custom-input" placeholder="Наименование" value="{{ request('name') }}">
                            </div>
                            <div class="adminPanelFilterItem">
                                <label>Цена:</label>
                                <input type="text" name="price1" class="custom-input" placeholder="Цена (от)" value="{{ request('price1') }}">
                                <input type="text" name="price2" class="custom-input" placeholder="Цена (до)" value="{{ request('price2') }}">
                            </div>
                        </div>
                        <div class="filter-group">
                            <div class="adminPanelFilterItem">
                                <label>Номер категории:</label>
                                <input type="text" name="category_id" class="custom-input" placeholder="Номер категории:" value="{{ request('category_id') }}">
                            </div>
                            <div class="filtergroup-Text">
                                В наличии:
                            </div>
                            <div class="radio-group">
                                <label class="radio-label">
                                    <input type="radio" class = "radioType" name="availability" value="all" {{ request('availability', 'all') == 'all' ? 'checked' : '' }}>
                                    <span>Все</span>
                                </label>
                                <label class="radio-label">
                                    <input type="radio" class = "radioType"name="availability" value="available" {{ request('availability') == 'available' ? 'checked' : '' }}>
                                    <span>В наличии</span>
                                </label>
                                <label class="radio-label">
                                    <input type="radio" class = "radioType" name="availability" value="unavailable" {{ request('availability') == 'unavailable' ? 'checked' : '' }}>
                                    <span>Не в наличии</span>
                                </label>
                            </div>
                        </div>
                        <div class="containerbuttonSubmit">
                            <button type="submit" class="custom-btn">Применить фильтры</button>
                        </div>
                    </form>


                </div>
                <form id="deleteProductsForm" method="POST" action="{{ route('ProductsDelete') }}">
                @csrf
                @method('DELETE')

                    <div class="adminPanelTableContainer">
                        <button type="submit" class="custom-btn danger-btn" id="deleteSelectedBtn" style="display: none">Удалить выбранное</button>
                        @if($products->isEmpty())
                            <div class="no-results-message">
                                Ничего не найдено
                            </div>
                        @else
                        <table class="adminPanelTable">
                            <thead>
                            <tr>
                                <th><input type="checkbox" class="adminPanelCheckbox" id="selectAll"></th>
                                <th>Изображение</th>
                                <th>Модель</th>
                                <th>Цена</th>
                                <th>Статус</th>
                                <th>Память</th>
                                <th>Номер категории</th>
                                <th>Действие</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                @include('masterProductsAdminPanel', compact('product', 'categories'))
                            @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
    @vite('resources/js/scriptAdminPanel.js')


@endsection

