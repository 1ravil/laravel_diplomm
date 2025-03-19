@extends('master')

@section('content')
    <div class="wrapper-container">
        <div class="wrapper-ForgotPassword">
            <h1>Восстановление пароля</h1>
            <div class="wrapper-ForgotPassword-text">
                Введите ваш email, и мы отправим ссылку для сброса пароля.
            </div>




            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="input-box">
                    <input type="email" name="email" placeholder="Ваш Email" required>
                </div>
                <button type="submit" class="btn">Отправить ссылку</button>
            </form>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="forgot-passwordAlertContainer">
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                </div>

            @endif
        </div>
    </div>
@endsection
