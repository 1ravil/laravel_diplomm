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
                    <a href="{{ route('adminPanelOrders') }}" class="adminPanelNavLink">
                        <i class='bx bx-shopping-bag'></i>
                        <span>Заказы</span>
                    </a>
                    <a href="{{ route('adminPanelCustomers') }}" class="adminPanelNavLink ">
                        <i class='bx bx-group'></i>
                        <span>Клиенты</span>
                    </a>
                    <a href="{{ route('adminPanelUsers') }}" class="adminPanelNavLink active">
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
                    <a href="{{ route('adminPanelUserCreate') }}" class="custom-btn">
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


                    <form id="filterForm" method="GET" action="{{ route('adminPanelUsersFilter') }}">
                        <div id="filterPanel" class="adminPanelFilters" style="display: none;">
                            <div class="adminPanelFilterGrid">
                                <div class="adminPanelFilterItem">
                                    <label>Электронная почта:</label>
                                    <input type="text" name="email" class="custom-input" placeholder="Электронная почта" value="{{ request('email') }}">
                                </div>
                                <div class="adminPanelFilterItem">
                                    <label>Имя пользователя:</label>
                                    <input type="text" name="name" class="custom-input" placeholder="Имя пользователя" value="{{ request('name') }}">
                                </div>
                                <div class="adminPanelFilterItem">
                                    <label>Роль:</label>
                                    <input type="text" name="role" class="custom-input" placeholder="1 - админ, 2 - пользователь" value="{{ request('role') }}">
                                </div>
                            </div>
                            <div class="filter-group">
                                <button type="submit" class="custom-btn">Применить фильтры</button>
                            </div>
                        </div>
                    </form>
                </div>
                <form id="deleteUserForm" method="POST" action="{{ route('UsersDelete') }}">
                    @csrf
                    @method('DELETE')
                    <div class="adminPanelTableContainer">
                        <button type="submit" class="custom-btn danger-btn" id="deleteSelectedBtn" style="display: none">Удалить выбранное</button>
                        @if($users->isEmpty())
                            <div class="no-results-message">
                                Ничего не найдено
                            </div>
                        @else
                        <table class="adminPanelTable">
                            <thead>
                            <tr>
                                <th><input type="checkbox" class="adminPanelCheckbox" id="selectAll"></th>
                                <th>№ пользователя</th>
                                <th>Имя пользователя</th> <!-- Имя клиента -->
                                <th>Дата регистрации</th> <!-- Номер телефона клиента -->
                                <th>Роль</th> <!-- Дата создания заказа -->
                                <th>Почта</th>
                                <th>Пароль</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                @include('masterUsersAdminPanel', compact('users'))
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
    @vite('resources/js/scriptAdminPanelUsers.js')




@endsection
