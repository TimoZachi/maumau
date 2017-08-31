@extends('admin.raw')

@section('styles')
    @parent

    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
@endsection

@section('wrapper')
<!-- INIT SIDEBAR -->
@include('admin.sidebar')
<!-- END SIDEBAR -->

<div class="main-panel">

    <!-- INIT NAVBAR -->
    @controller('Admin\IndexController@navbar')
    <!-- END NAVBAR -->

    <!-- INIT CONTENT -->
    <div class="content">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
    <!-- END CONTENT -->

    <!-- INIT FOOTER -->
    @include('admin.footer')
    <!-- END FOOTER -->

</div>
@endsection

@section('scripts')
    @parent

    <script type="text/javascript" src="{{ asset('assets/js/admin/demo.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/both.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/admin/admin.js') }}"></script>
@endsection