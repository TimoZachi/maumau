@section('title', 'Jogo')

@extends($base_layout)

@section('content')

<link rel="stylesheet" href="{{ asset('assets/css/sweetalert.css') }}">

<div class="game2">
    <div class="game-inside">
        <div id="game-table" class="game-table2 center-block-absolute">
            <img src="{{ asset('assets/img/table-big.png') }}" class="center-block-absolute">
            <div class="arrows" data-base-uri="{{ asset('assets/img/') . '/' }}">
                <img src="{{ asset('assets/img/arrows-c.png') }}">
            </div>
            @foreach($positions as $i=>$pos)
                <div class="user user{{ $pos }}" data-id="{{ $players[$i]['user']->id }}" style="width:{{ ($players[$i]['cards'] - 1) * 10 + 215 }}px">
                    <div class="info">
                        <div class="frame"><img src="{{ $players[$i]['user']->avatar }}" height="100" class="center-block-absolute-x"></div>
                        <p>{{ $players[$i]['user']->name }}</p>
                    </div>
                    <div class="cards" style="width:{{ ($players[$i]['cards'] - 1) * 10 + 85 }}px">
                        @for($j = 0; $j < $players[$i]['cards']; $j++)
                            <div class="card-back" style="left:{{ $j * 10 }}px;"></div>
                        @endfor
                    </div>
                </div>
            @endforeach
            <div class="center-card center-block-absolute">
                <div id="table-card"></div>
                <div class="suit" data-base-uri="{{ asset('assets/img/upload/suits') . '/' }}" style="display:none;">
                    <img src="" width="25" class="center-block-absolute-x">
                </div>
            </div>
            <div class="table-deck" title="Comprar cartas">
                <div class="card-back"></div>
            </div>
            <div class="last-card">Maumau!</div>
            <div class="awaiting-players">
                <div class="center-block-absolute">
                    <p>Aguardando outros jogadores</p>
                    <svg width='56px' height='56px' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="uil-default center-block-absolute-x"><rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#ffffff' transform='rotate(0 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#ffffff' transform='rotate(30 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.08333333333333333s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#ffffff' transform='rotate(60 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.16666666666666666s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#ffffff' transform='rotate(90 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.25s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#ffffff' transform='rotate(120 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.3333333333333333s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#ffffff' transform='rotate(150 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.4166666666666667s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#ffffff' transform='rotate(180 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.5s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#ffffff' transform='rotate(210 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.5833333333333334s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#ffffff' transform='rotate(240 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.6666666666666666s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#ffffff' transform='rotate(270 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.75s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#ffffff' transform='rotate(300 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.8333333333333334s' repeatCount='indefinite'/></rect><rect  x='46.5' y='40' width='7' height='20' rx='5' ry='5' fill='#ffffff' transform='rotate(330 50 50) translate(0 -30)'>  <animate attributeName='opacity' from='1' to='0' dur='1s' begin='0.9166666666666666s' repeatCount='indefinite'/></rect></svg>
                </div>
            </div>
        </div>
    </div>
    <div class="cards-panel">
        <div class="cards">
            @foreach($player['cards'] as $card)
                @include('card-template', ['card' => $card, 'tag' => 'div'])
            @endforeach
        </div>
    </div>
</div>

<div id="suits-container">
    <div id="suit-selector">
        @foreach($suits as $suit)
        <div class="suit" data-id="{{ $suit->id }}" title="{{ $suit->name }}">
            <img src="{{ asset('assets/img/upload/suits/' . $suit->icon) }}" alt="{{ $suit->name }}">
        </div>
        @endforeach
    </div>
</div>

<script type="text/javascript" src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/pages/game.js') }}"></script>

@endsection