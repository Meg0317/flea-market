<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>flea-market</title>
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
    <link rel="stylesheet" href="{{ asset('css/common.css')}}">
    @yield('css')
</head>


<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">
                <a href="/">
                    <img src="{{ asset('images/logo.svg') }}" alt="COACHTECK">
                </a>
                <form class="search-form" action="/item/search" method="get">
                @csrf
                    <input class="header__inner__keyword-input"
                        type="text"
                        name="keyword"
                        placeholder="なにをお探しですか？"
                        value="{{ request('keyword') }}">
                </form>
                <nav>
                    <ul class="header-nav">
                        @guest
                            {{-- ログイン前 --}}
                            <li class="header-nav__item">
                                <a class="header-nav__link" href="{{ url('/login') }}">ログイン</a>
                            </li>
                        @endguest

                        @auth
                            {{-- ログイン後 --}}
                            <li class="header-nav__item">
                                <form class="form" action="{{ url('/logout') }}" method="post">
                                    @csrf
                                    <button type="submit" class="header-nav__button">ログアウト</button>
                                </form>
                            </li>
                        @endauth

                        <li class="header-nav__item">
                            <a class="header-nav__link" href="/mypage">マイページ</a>
                        </li>

                        <li class="header-nav__item header-nav__item--sell">
                            <a href="/sell">出品</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <div class="content">
        @yield('content')
    </div>
</body>

</html>