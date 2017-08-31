@extends('layout')

@section('title', 'Jogar')

@section('content')

<script type="text/javascript">
window.CONFIG = {
    user:{!! json_encode($user) !!},
    token:"{{ $token }}",
    host:"{{ explode('/', preg_replace('/^https?:\\/\\//', '', url('/')))[0] }}",
    port:"{{ $port }}"
};
</script>

<div id="sidebar" class="sidebar">
    <div class="logo">
        <a href="{{ route('home') }}" class="center-block-absolute">
            <img src="{{ asset('assets/img/logo-small.png') }}">
        </a>
    </div>
    <div class="toggle-button">
        <button type="button" id="btn-toggle-table" class="btn btn-primary" disabled>
            Sentar em uma cadeira livre
        </button>
    </div>
    <div id="main-panel" class="panel panel-default">
        <div class="panel-heading">Jogadores Conectados</div>
        <div class="panel-body online">
            <table id="table-players" class="table table-striped">
                <thead>
                <tr>
                    <th width="40" class="text-center">#</th>
                    <th>Jogador</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<div class="game">
    <div class="game-inside">
        <div id="game-table" class="game-table center-block-absolute" style="display:none;">
            <img src="{{ asset('assets/img/table.png') }}" class="center-block-absolute">
            <div class="user1">
                <div class="frame"></div>
                <p></p>
            </div>
            <div class="user2">
                <div class="frame"></div>
                <p></p>
            </div>
            <div class="user3">
                <div class="frame"></div>
                <p></p>
            </div>
            <div class="user4">
                <div class="frame"></div>
                <p></p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    @parent

    <script type="text/javascript" src="{{ asset('assets/js/class/EventDispatcher.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/class/WSWrapper.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/pages/jogar.js') }}"></script>
@endsection