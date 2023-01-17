<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ config('app.name', 'Laravel') }}  </title>

    @include('layouts.style')
</head>
<body class="auth">

<!-- preloader -->
<div class="preloader">
    <img src="{{asset('images/logo.png')}}" alt="logo">
    <div class="preloader-icon"></div>
</div>



    <!-- ./ header -->

    <!-- content -->
    <div class="form-wrapper ">
        @yield('content')
    </div>
    <!-- ./ content -->

    <!-- content-footer -->
    <footer class="content-footer">
        <div>© {{date('Y')}}  {{ config('app.name', 'Laravel') }}. All Rights Reserved</div>
    </footer>
    <!-- ./ content-footer -->

</div>

@include('layouts.scripts')
</body>
</html>
