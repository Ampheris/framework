<html lang="en">
    <head>
        <title>App Name - @yield('title')</title>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="stylesheet" type="text/css" href="{{asset("css/style.css")}}">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    </head>

    <body>
    <header>
        <h1>Laravel framework</h1>
        <nav>
            <a href="<?= url("/") ?>">Home</a> |
            <a href="<?= url("/diceGame") ?>">Dice 21</a> |
            <a href="<?= url("/session") ?>">Restart session</a>
        </nav>

    </header>

    <div class="container">
        @yield('content')
    </div>
    </body>
</html>
