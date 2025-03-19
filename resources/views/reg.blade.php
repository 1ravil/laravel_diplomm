@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp

@section('content')

    <div class="wrapper-container1">
        <div class="wrapper1">
            <form action="{{ route('userCreate') }}" method="post">
                @csrf
                <h1>Регистрация</h1>
                <div class="alert-container">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                            <div class="haveAnaccount-Container1">
                                <a href="{{ route('login') }}" class="haveAnaccount1" role="button">
                                    </br>Войти
                                </a>
                            </div>
                        </div>

                    @endif
                </div>
                <div class="input-box">
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Имя" required>
                    <i class='bx bx-user'></i>
                </div>

                <div class="input-box">
                    <input type="text" id="surname" name="surname" value="{{ old('surname') }}" placeholder="Фамилия" required>
                    <i class='bx bx-user'></i>
                </div>

                <div class="input-box">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Почта" required>
                    <i class='bx bx-user'></i>
                </div>

                <div class="input-box">
                    <input type="password" id="password" name="password" placeholder="Пароль" required>
                    <i class='bx bxs-lock-alt'></i>
                    <span class="btn-pas" onclick="togglePassword('password')">
                    <img src="{{ Vite::asset('resources/img/eyes.png') }}" alt="" class="input-icon">
                </span>
                </div>

                <div class="input-box">
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Подтвердите пароль" required>
                    <i class='bx bxs-lock-alt'></i>
                    <span class="btn-pas" onclick="togglePassword('password_confirmation')">
                    <img src="{{ Vite::asset('resources/img/eyes.png') }}" alt="" class="input-icon">
                </span>
                </div>

                <button type="submit" class="btn" role="button">
                    Зарегистрироваться
                </button>
            </form>

            <div class="haveAnaccount-Container">
                <a href="{{ route('login') }}" class="haveAnaccount" role="button">
                    Уже есть аккаунт?
                </a>
            </div>
        </div>
    </div>





    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const passwordType = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', passwordType);
        }
    </script>

@endsection
