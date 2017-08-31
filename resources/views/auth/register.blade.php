@extends('admin.raw')

@section('title', 'Cadastro')

@section('wrapper')
    <div class="main-panel main-panel-full">
        <div class="content">
            <div class="card">
                <div class="header">
                    <h4 class="title">Cadastre-se</h4>
                </div>
                <div class="content">
                    <form class="form" action="{{ route('register') }}" method="post">
                        {!! method_field('post') !!}
                        <div class="form-group @if($errors->has('name')) has-error @endif ">
                            <label class="control-label">Nome</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            <p class="help-block">{{ $errors->first('name') }}</p>
                        </div>
                        <div class="form-group @if($errors->has('email')) has-error @endif ">
                            <label class="control-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            <p class="help-block">{{ $errors->first('email') }}</p>
                        </div>
                        <div class="form-group @if($errors->has('password')) has-error @endif ">
                            <label class="control-label">Senha</label>
                            <input type="password" name="password" class="form-control">
                            <p class="help-block">{{ $errors->first('password') }}</p>
                        </div>
                        <div class="form-group @if($errors->has('password_confirmation')) has-error @endif ">
                            <label class="control-label">Confirmar Senha</label>
                            <input type="password" name="password_confirmation" class="form-control">
                            <p class="help-block">{{ $errors->first('password_confirmation') }}</p>
                        </div>
                        <div class="form-group text-right">
                            <input type="submit" class="btn btn-primary btn-fill" value="Cadastrar">
                        </div>
                        {!! csrf_field() !!}
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection