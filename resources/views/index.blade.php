<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тестовая авторизация</title>
    
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap&subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@500&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('resources/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/bootstrap.css') }}">
    <script src="{{ asset('resources/js/script.js') }}" defer></script>
</head>

<body>
    <div class="container">
        <div class="box-authorization">
            <div class="container-authorization">
                <h1>Вход</h1>
                <div class="card-body">

                    <form class="form mb-3" id="loginForm" action="/api/v1/login" method="post">
                        <div class="mb-3">
                            <input type="text" name="email" class="form-control" placeholder="Логин" value="stepblazev2018@mail.ru">
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Пароль">
                        </div>
                        <div class="button_authorization">
                            <input type="submit" name="login" class="btn btn-primary" value="Войти">
                        </div>
                    </form>
                    <p><a href="#">Забыли пароль?</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>