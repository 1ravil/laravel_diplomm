@extends('master')

@section('content')
    <div class="wrapper-container">
        <div class="wrapper">
            <h1>Подтверждение Email</h1>
            <p>На вашу почту отправлена ссылка для подтверждения.</p>
            <p>Если письмо не пришло, <a href="{{ route('verification.resend') }}">нажмите здесь</a> для повторной отправки.</p>
        </div>
    </div>
@endsection
