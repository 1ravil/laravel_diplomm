@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp

@section('content')

<div class="login-headerContainer">
    <div class="login-header">
        Авторизация
    </div>
</div>
<div class="wrapper-container">
    <div class="wrapper-container">
        <div class="wrapper">


                <form action="{{ route('loginAuth') }}" method="POST">
                @csrf <!-- Добавьте защиту CSRF -->
                <h1>Авторизация</h1>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                <div class="input-box">
                    <input type="text" name="username" placeholder="Имя пользователя" required>
                    <i class='bx bx-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Пароль" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="remember">
                    <label class="checkbox-wrapper">
                        <input type="checkbox" class="custom-checkbox">
                        <span class="checkmark1"></span>
                        <span class="remember-text">Запомнить меня</span>
                    </label>
                    <a href="{{ route('password.request') }}">Забыли пароль?</a>
                </div>

                <button type="submit" class="btn">Логин</button>

                <div class="register-link">
                    <p>Нет аккаунта? <a href="{{ route('register') }}">Регистрация</a></p>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
