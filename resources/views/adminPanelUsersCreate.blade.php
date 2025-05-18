@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp
@section('content')

    <div class="cartProductTitle-container">
        <div class="cartProduct-Title">Добавление пользователя</div>
    </div>

    <div class="cartProduct-container">
        <form action="{{ route('adminPanelUserStore')}}" class="formInsertProduct" method="POST" enctype="multipart/form-data">
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
                <input class="inputInsert" type="text" name="name" placeholder="Имя пользователя" value="{{ old('name') }}" required>

                <input class="inputInsert" type="text" name="role" placeholder="Роль (1 - простой пользователь, 2 - админ)" value="{{ old('role') }}" required>
            </div>

            <div class="InsertBlock">
                <input class="inputInsert" type="text" name="email" placeholder="Электронная почта" value="{{ old('email') }}" required>

                <input class="inputInsert" type="password" name="password" placeholder="Пароль" required>
            </div>

            <button type="submit" class="SaveInsert">Сохранить</button>
        </form>

    </div>

@endsection
