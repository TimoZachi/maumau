@extends('admin.layout')

@section('title', 'Associar cartas a: ' . $deck['name'])

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="card">
                <div class="header">
                    <h4 class="title">Associar cartas a: {{ $deck['name'] }}</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5>Associadas</h5>
                            <ul id="associated" class="deck clearfix cards-associated"
                                data-save="{{ route('admin.decks.associate-cards', ['id' => $deck['id']]) }}">
                                @foreach($cards_associated as $card)
                                    @include('card-template', ['card' => $card, 'class' => 'drag', 'tag' => 'li'])
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <h5>Não Associadas</h5>
                            <ul id="non-associated" class="deck clearfix cards-non-associated">
                                @foreach($cards_not_associated as $card)
                                    @include('card-template', ['card' => $card, 'class' => 'drag', 'tag' => 'li'])
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="footer clearfix">
                    <button id="btn-save" class="btn btn-info btn-fill pull-right top-action">
                        Salvar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    <script type="text/javascript" src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/admin/baralhos-associar-cartas.js') }}"></script>
@endsection