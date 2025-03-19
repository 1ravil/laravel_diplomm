@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp
@section('title', 'Редактирование: ' . $users->name)
@section('content')

    <div class="cartProductTitle-container">
        <div class="cartProduct-Title">Редактирование товара</div>
    </div>

    <div class="cartProduct-container">
        <form action="{{ route('usersUpdate', $users->id) }}" class="formInsertProduct" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="InsertBlock">
                <input class="inputInsert" type="text" name="name" value="{{ $users->name }}" placeholder="Имя пользователя" required>

                <input class="inputInsert" type="text" name="role" value="{{ $users->role }}" placeholder="Роль (1 - простой пользователь, 2 - админ)" required>

            </div>
            <div class="InsertBlock">
                <input class="inputInsert" type="text" name="email" value="{{ $users->email }}" placeholder="Электронная почта" required>

                <input class="inputInsert" type="password" name="password" placeholder="Новый пароль (необязательно)">


            </div>




            <button type="submit" class="SaveInsert">Сохранить</button>
        </form>

    </div>

@endsection
