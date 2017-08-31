<!DOCTYPE html>
<html lang="pt-BR">
<head>

    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.ico') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>MauMau - @yield('title')</title>

    <!-- Bootstrap core CSS     -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/both.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    @yield('styles')
</head>
<body>

<div class="container-fluid wrapper">
    <!-- INIT NAVBAR -->
    @controller('IndexController@navbar')
    <!-- END NAVBAR -->

    <!-- INIT CONTENT -->
    @yield('content')
    <!-- END CONTENT -->
</div>

@yield('modals')

<!--   Core JS Files   -->
<script type="text/javascript" src="{{ asset('assets/js/jquery-1.10.2.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

<!--  Notifications Plugin    -->
<script type="text/javascript" src="{{ asset('assets/js/notify.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/js/both.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>

<script type="text/javascript">
var BASE_URL = "{!! url('/') !!}/";
</script>
@yield('scripts')

</body>
</html>
