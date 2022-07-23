<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else

                            @if(isset($categoryId))  {{--以下のプルダウンで、$categoryIdという変数を用いているので、エラーが出ないように$categoryIdが存在していない時とNULLの時はこのプルダウン自体を表示させないようにした。--}}
                                <form method="GET" action="{{ route('task.index') }}">
                                    <div class="form-inline">
                                        <select onchange="submit(this.form)" name="category" class="nav-link">
                                                <option value="" {{ $categoryId == '' ? 'selected' : '' }}>カテゴリ選択</option>
                                            @foreach($pulldownCategories as $pulldownCategory)
                                                <option value="{{$pulldownCategory->id}}" {{ $categoryId == $pulldownCategory->id ? 'selected' : '' }}>{{$pulldownCategory->name}}</option> {{--選択された項目が初期値になるようにselected属性を追加--}}
                                            @endforeach
                                        </select>
                                        <select onchange="submit(this.form)" name="work_user" class="nav-link mx-2">
                                                <option value="" {{ $workUserId == '' ? 'selected' : '' }}>担当者選択</option>
                                            @foreach($pulldownUsers as $pulldownUser)
                                                <option value="{{$pulldownUser->id}}" {{ $workUserId == $pulldownUser->id ? 'selected' : '' }}>{{$pulldownUser->name}}</option> {{--選択された項目が初期値になるようにselected属性を追加--}}
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            @endif

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
