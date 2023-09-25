<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('ttlbar')</title>
    <link rel="shortcut icon" href="{{ asset('img/nao.png') }}">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}"/>
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    @yield('css')
</head>
<header class="header">
    <div class="header__inner">
        <h2 class="header__logo">
            @yield('ttl')
        </h2>
    </div>
</header>

<body>
<main>
    @yield('content')
</main>
    @yield('js')
</body>
</html>
