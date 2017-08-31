<!DOCTYPE html>
<html lang="pt-BR">
<head>

    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.ico') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>MauMau Painel - @yield('title')</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'>
    <meta name="viewport" content="width=device-width">

    <!-- Bootstrap core CSS     -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- Animation library for notifications   -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">

    <!--  Light Bootstrap Table core CSS    -->
    <link rel="stylesheet" href="{{ asset('assets/css/light-bootstrap-dashboard.css') }}">

    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,700,300">
    <link rel="stylesheet" href="{{ asset('assets/css/pe-icon-7-stroke.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/both.css') }}">

    @yield('styles')
</head>
<body>

<div class="wrapper">

    @yield('wrapper')

</div>

@yield('modals')

<script type="text/javascript">
    var BASE_URL = "{!! url('/') !!}/";
</script>

<!--   Core JS Files   -->
<script type="text/javascript" src="{{ asset('assets/js/jquery-1.10.2.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

<!--  Checkbox, Radio & Switch Plugins -->
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-checkbox-radio-switch.js') }}"></script>

<!--  Charts Plugin -->
<script type="text/javascript" src="{{ asset('assets/js/chartist.min.js') }}"></script>

<!--  Notifications Plugin    -->
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-notify.js') }}"></script>

<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script type="text/javascript" src="{{ asset('assets/js/light-bootstrap-dashboard.js') }}"></script>

@yield('scripts')

</body>
</html>
