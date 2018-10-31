<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @section('styles')
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    @show
</head>
<body>
    <div class="page-wrapper">
        @section('header')
            {{-- logo  title--}}
            <header class="header">
                <a href="/" class="header__logo">
                    <div class="header__logo-icon icon-share-white"></div>
                    <h1 class="header__logo-text">
                        Filehost
                    </h1>
                </a>
                <form class="header__search" action="/search/" method="get" id="js-search">
                    @csrf
                    <input class="header__search-input" type="text" name="search-input" id="js-search-input">
                    <button class="header__search-btn" type="submit">
                        <div class="header__search-icon icon-search"></div>
                    </button>
                </form>
            </header>
            <div id="js-error-block" class="search-error-message">
                <p id="js-error-text" class="search-error-message__text">

                </p>
            </div>
        @show
        <section class="body">
            @yield('content')
        </section>
        @section('footer')
            <footer class="footer">
                <p class="footer__text">&copy; 2017-2019</p>
            </footer>
        @show
    </div>
    @section('scripts')
        <script src="{{mix('/js/app.js')}}"></script>
    @show
</body>
</html>
