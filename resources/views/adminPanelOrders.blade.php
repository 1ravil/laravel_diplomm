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
                    <span>AppleZone</span>
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
                        <a href="{{ route('adminPanel') }}" class="adminPanelNavLink">
                            <i class='bx bx-package'></i>
                            <span>Товары</span>
                        </a>
                        <a href="{{ route('adminPanelCategory') }}" class="adminPanelNavLink ">
                            <i class='bx bx-category'></i>
                            <span>Категории</span>
                        </a>
                    </div>

                    <div class="adminPanelNavSection">
                        <div class="adminPanelNavHeader">ПРОДАЖИ</div>
                        <a href="{{ route('adminPanelOrders') }}" class="adminPanelNavLink active">
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
                        <h1>Заказы</h1>
                    </div>
                    <div class="adminPanelHeaderRight">
                        <button id="filterToggleButton" class="custom-btn">Фильтр</button>
                        <span class="adminPanelUserName">{{auth()->user()->name}}</span>
                        <button class="adminPanelLogoutBtn">Выход</button>
                    </div>
                </header>

                <div class="adminPanelContent">
                    <div class="adminPanelContentCard">
                        <form id="filterForm" method="GET" action="{{ route('adminPanelOrdersFilter') }}">
                            <div id="filterPanel" class="adminPanelFilters" style="display: none;">
                                <div class="adminPanelFilterGrid">
                                    <div class="adminPanelFilterItem">
                                        <label>Номер заказа:</label>
                                        <input type="text" name="order_id" class="custom-input" placeholder="Номер заказа" value="{{ request('order_id') }}">
                                    </div>
                                    <div class="adminPanelFilterItem">
                                        <label>Имя клиента:</label>
                                        <input type="text" name="customer_name" class="custom-input" placeholder="Имя клиента" value="{{ request('customer_name') }}">
                                    </div>
                                    <div class="adminPanelFilterItem">
                                        <label>Номер телефона:</label>
                                        <input type="text" name="phone" class="custom-input" placeholder="Номер телефона" value="{{ request('phone') }}">
                                    </div>
                                </div>
                                <div class="filter-group">
                                    <div class="filtergroup-Text">
                                        Сортировка по цене:
                                    </div>
                                    <div class="radio-group">
                                        <label class="radio-label">
                                            <input type="radio" class="radioType" name="sort_price" value="asc" {{ request('sort_price') == 'asc' ? 'checked' : '' }}>
                                            <span>По убыванию</span>
                                        </label>
                                        <label class="radio-label">
                                            <input type="radio" class="radioType" name="sort_price" value="desc" {{ request('sort_price') == 'desc' ? 'checked' : '' }}>
                                            <span>По возрастанию</span>
                                        </label>
                                    </div>
                                    <button type="submit" class="custom-btn">Применить фильтры</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Форма для удаления -->
                    <form id="deleteOrdersForm" method="POST" action="{{ route('OrdersDelete') }}">
                        @csrf
                        @method('DELETE')
                        <div class="adminPanelTableContainer">
                            <button type="submit" class="custom-btn danger-btn" id="deleteSelectedBtn" style="display: none;">
                                Удалить выбранное
                            </button>
                            @if($orders->isEmpty())
                                <div class="no-results-message">
                                    Ничего не найдено
                                </div>
                            @else
                            <table class="adminPanelTable">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" class="adminPanelCheckbox" id="selectAll"></th>
                                    <th>№ заказа</th>
                                    <th>Имя клиента</th>
                                    <th>Номер телефона</th>
                                    <th>Дата создания</th>
                                    <th style="display:flex;  padding-top: 15px">Наименование товара</th>
                                    <th>Количество</th>
                                    <th>Цена</th>
                                    <th>Перезвонить?</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    @include('masterOrdersAdminPanel', compact('order'))
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
        @vite('resources/js/scriptAdminPaneOrders.js')


    @endsection
