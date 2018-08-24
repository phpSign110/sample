<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Sample APP')- Laravel 新手入门教程 </title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
@include('layouts._header'){{--引入顶部视图--}}

<div class="container">
    <div class="col-md-offset-1 col-md-10">
        @include('shared._messages') {{--闪存提示信息 --}}
        @yield('content')
        @include('layouts._footer'){{--引入底部视图--}}
    </div>
</div>

<script src="/js/app.js"></script>
</body>
</html>