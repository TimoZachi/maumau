<nav class="navbar navbar-default">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ route('home') }}">MauMau Online</a>
    </div>
    <div class="collapse navbar-collapse">
        <!--<ul class="nav navbar-nav navbar-left">
            <li>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-dashboard"></i>
                </a>
            </li>
        </ul>-->

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user"></i>
                    {{ $user['name'] }}
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#" data-toggle="modal" data-target="#modal-user"
                           data-load="{{ route('users.edit') }}">
                            Meu Perfil
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="{{ route('logout') }}">Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

@section('modals')
    @parent

    <div id="modal-user" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
@endsection