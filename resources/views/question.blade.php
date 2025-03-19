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
    <link href="https://fonts.googleapis.com/css2?family=Cookie&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=Open+Sans:wght@400;800&family=Tinos:wght@400;700&display=swap" rel="stylesheet">
    <title>AppleZone</title>
</head>
<body>



<header>
    <div class="header-line">
        <div class="img-logo">
            <img class="apple-img1" src="{{ Vite::asset('resources/img/AppleZoneLogo1.png') }}" alt="">
        </div>
        <nav>
            <div class="nav-container">
                <a class="nav-item" href="/">Главное</a>
                <a class="nav-item" href="garanty">Гарантия</a>
                <a class="nav-item" href="installment">Рассрочка</a>
                <a class="nav-item" href="contacts">Контакты</a>
                <a class="nav-item" href="catalog">Каталог</a>
                <a class="nav-item" href="login">Вход</a>
            </div>
        </nav>
    </div>
</header>


<question>
    <div class="question-container">
        <div class="question-title">
            Частые вопросы
        </div>
    </div>
    <div class="card-container1">
        <div class="cards-holder1">
            <div class="card-right">
                <div class="card-title1">
                    Как получить гарантийное обслуживание?
                </div>
                <div class="card-subtitle1">
                    Вам необходимо обратиться в авторизованный сервисный центр. Для обращения необходим только гаджет.
                </div>
            </div>
        </div>

        <div class="cards-holder1">
            <div class="card-right">
                <div class="card-title1">
                    В каких случаях не действует дополнительная гарантия от магазина 2 года?
                </div>
                <div class="card-subtitle1">
                    Мы не предоставляем иные гарантии, помимо указанных в предыдущем пункте (в том числе мы не
                    гарантируем совместимость приобретенной техники с другими изделиями). <br>Гарантия не распространяется на случаи:
                    <br>a) какого-либо особого или косвенного ущерба / убытков;
                    <br>b) упущенной выгоды;
                    <br>c) потерь информации с устройства или невозможности ее использования;
                    <br>d) трат на восстановление утерянных данных;
                    <br>e) финансовых потерь в результате использования (либо невозможности использования) техники и др.
                    <br>f) Также гарантия не действует на комплектующие устройства, поставляющиеся с товаром:
                    <br>g) проводную гарнитуру,
                    <br>h) USB-кабель,
                    <br>i) АКБ,
                    <br>j) флэш-карту,
                    <br>k) зарядное устройство.
                </div>
            </div>
        </div>

        <div class="cards-holder1">
            <div class="card-right">
                <div class="card-title1">
                    Основания для отказа в бесплатном ремонте у нас в магазине:
                </div>
                <div class="card-subtitle1">
                    Ремонт по гарантийному талону осуществляется в случае обнаружения заводского брака. Гарантия не распространяется на случаи, когда устройство вышло из строя не по вине производителя.<br>
                    К таким ситуациям относятся:
                    <br>a) повреждения из-за попадания жидкости, механических воздействий, стихийных или техногенных катастроф и др.;
                    <br>b) проблемы, вызванные некорректным использованием (применением не по назначению и/или с нарушением условий, указанных в инструкции к устройству).
                    <br>В некоторых случаях сервисный центр может отказать в бесплатном ремонте, если на устройстве будут обнаружены:
                    <br>c) Jailbreak и другие следы взлома файловой системы;
                    <br>f) установка программного обеспечения бета-версии.
                </div>
            </div>
        </div>


    </div>


    <footer>
        <div class="footer-container1">
            <div class="footer-text1">
                Сайт носит сугубо информационный характер и не является публичной офертой, определяемой Статьей 437 (2) ГК РФ. Apple, логотип Apple и изображения Apple являются зарегистрированными товарными знаками компании Apple Inc. в США и других странах. App Store является знаком обслуживания компании Apple Inc. Instagram принадлежит компании Meta, признанной экстремистской организацией и запрещенной в РФ.
            </div>
        </div>
    </footer>


</question>

</body>
</html>
