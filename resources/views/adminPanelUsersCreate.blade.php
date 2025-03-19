@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp
@section('content')

    <div class="cartProductTitle-container">
        <div class="cartProduct-Title">Добавление пользователя</div>
    </div>

    <div class="cartProduct-container">
        <form action="{{ route('adminPanelUserStore')}}" class="formInsertProduct" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="InsertBlock">
                <input class="inputInsert" type="text" name="name" placeholder="Имя пользователя" required>

                <input class="inputInsert" type="text" name="role" placeholder="Роль (1 - простой пользователь, 2 - админ)" required>

            </div>
            <div class="InsertBlock">
                <input class="inputInsert" type="text" name="email" placeholder="Электронная почта" required>

                <input class="inputInsert" type="password" name="password" placeholder="Пароль" required>
            </div>
            <button type="submit" class="SaveInsert">Сохранить</button>
        </form>

    </div>

@endsection
