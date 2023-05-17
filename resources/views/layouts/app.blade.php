<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{ config('app.name') }}  </title>

    @include('layouts.style')
</head>
<body>

<!-- preloader -->
<div class="preloader">
    <img src="{{asset('images/logo.png')}}" alt="logo">
    <div class="preloader-icon"></div>
</div>


@include('layouts.sitemap')



    <!-- ./ header -->

    <!-- content -->
    <div class="content ">
        @yield('content')
    </div>
    <!-- ./ content -->

    <!-- content-footer -->
    <footer class="content-footer">
        <div>© {{date('Y')}}  {{ config('app.name', 'Laravel') }}. All Rights Reserved. Powered By <a href="https://zenith-codes.com/">Zenith Codes</a>.</div>
    </footer>
    <!-- ./ content-footer -->

</div>

@include('layouts.scripts')

</body>
</html>
