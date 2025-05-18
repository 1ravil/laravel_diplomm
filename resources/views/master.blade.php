@php use Illuminate\Support\Facades\Vite; @endphp
    <!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/style.css', 'resources/css/reset.css'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cookie&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Open+Sans:wght@400;800&family=Tinos:wght@400;700&display=swap"
        rel="stylesheet">
    <title>AppleZone: @yield('title')</title>
</head>
<body>


<header>
    <div class="header-line">
        <div class="img-logo">
            <img class="apple-img1" src="{{ Vite::asset('resources/img/AppleZoneLogo22.png') }}" alt="">
        </div>
        <div class="nav-container">
            <a class="nav-item" href="{{ route('index') }}">Главное</a>
            <a class="nav-item" href="{{ route('garanty') }}">Гарантия</a>
            <a class="nav-item" href="{{ route('installment') }}">Рассрочка</a>
            <a class="nav-item" href="{{ route('contacts') }}">Контакты</a>
            <a class="nav-item" href="{{ route('catalog') }}">Каталог</a>
            <a class="nav-item" href="{{ route('cartPage') }}">Корзина</a>

            @auth
                @if(auth()->user()->role === 2)
                    <a class="nav-item" href="{{ route('adminPanel') }}">Панель администратора</a>
                @elseif(auth()->user()->role === 1)
                    <a class="nav-item" href="{{ route('user.orders') }}">Мои заказы</a>
                @endif

                <a class="nav-item" href="{{ route('logout') }}" id="logout-link">Выход</a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a class="nav-item" href="{{ route('login') }}">Вход</a>
            @endauth

        </div>

    </div>
</header>
<script>
    document.getElementById('logout-link').addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById('logout-form').submit();
    });
</script>

@yield('content')



</body>
</html>
