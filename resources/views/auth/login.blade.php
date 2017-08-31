@extends('admin.raw')

@section('title', 'Login')

@section('wrapper')
    <div class="main-panel main-panel-full">
        <div class="content">
            <div class="card">
                <div class="header">
                    <h4 class="title">Login</h4>
                </div>
                <div class="content">
                    @if($errors->has('email') || $errors->has('password'))
                        <div class="alert alert-danger">
                            <button type="button" aria-hidden="true" class="close" data-dismiss="alert">×</button>
                            <span>Email e/ou senha incorretos</span>
                        </div>
                    @endif
                    @if(Session::has('logout'))
                        <div class="alert alert-info">
                            <button type="button" aria-hidden="true" class="close" data-dismiss="alert">×</button>
                            <span>Logout realizado com sucesso</span>
                        </div>
                    @endif
                    <form class="form" action="" method="post">
                        {!! method_field('post') !!}
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Senha</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <label class="checkbox">
                            <input type="checkbox" name="remember" value="1" data-toggle="checkbox">
                            Lembrar
                        </label>
                        <div class="form-group text-right">
                            <input type="submit" class="btn btn-primary btn-fill" value="Login">
                        </div>
                        {!! csrf_field() !!}
                    </form>
                    <p>Não tem login? <a href="{{ route('register') }}">Cadastre-se</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection