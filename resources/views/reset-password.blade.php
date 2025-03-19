@extends('master')

@section('content')
    <div class="wrapper-container">
        <div class="wrapper">
            <h1>Сброс пароля</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="input-box">
                    <input type="email" name="email" placeholder="Ваш Email" required>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Новый пароль" required>
                </div>
                <div class="input-box">
                    <input type="password" name="password_confirmation" placeholder="Подтвердите пароль" required>
                </div>
                <button type="submit" class="btn">Сбросить пароль</button>
            </form>
        </div>
    </div>
@endsection
