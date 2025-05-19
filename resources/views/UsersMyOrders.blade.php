@extends('master')
<ы></ы>
@section('content')
    <div class="adminpanelContainer">
        <div class="adminPanel">
            Мои заказы
        </div>
    </div>
    <div class="adminPanelWrapperContainer">
        <div class="adminPanelWrapper">
            <main class="adminPanelMainContent">
                <header class="adminPanelMainHeader">
                    <h1>История заказов</h1>
                    <span class="adminPanelUserName" style="font-size: 20px">{{ auth()->user()->name }}</span>
                </header>
                <div class="adminPanelContent">
                    @if($orders->isEmpty())
                        <div class="no-results-message">
                            Ничего не найдено. Ждем тебя в каталоге :)
                        </div>
                    @else
                        <table class="adminPanelTable">
                            <thead>
                            <tr>
                                <th>Номер заказа</th>
                                <th style="padding-left: 35px;">Дата</th>
                                <th>Клиент</th>
                                <th>Телефон</th>
                                <th style="padding-left: 20px;">Товары</th>
                                <th>Количество</th>
                                <th>Общая сумма</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td style="padding-left: 50px;">{{ $order->order_id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y') }}</td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td>{{ $order->phone }}</td>
                                    <td>{{ $order->product_names}}</td>
                                    <td style="padding-left: 45px;">{{ $order->total_count }}</td>
                                    <td>{{ $order->total_price }} ₽</td>
                                    <td>
                                        <form action="{{ route('user.order.delete') }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите отменить заказ?');">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                                            <button type="submit" class="adminPanelActionBtn">Отменить заказ</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </main>
        </div>
    </div>
@endsection
