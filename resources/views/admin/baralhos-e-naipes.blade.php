@extends('admin.layout')

@section('title', 'Baralhos e Naipes')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <button class="btn btn-info btn-fill pull-right top-action"
                            data-toggle="modal" data-target="#modal-deck"
                            data-load="{{ route('admin.decks.create') }}"
                    >
                        <i class="icon pe-7s-plus"></i>&nbsp;Novo
                    </button>
                    <h4 class="title">Baralhos</h4>
                </div>
                <div class="content table-responsive table-full-width">
                    @controller('Admin\DeckController@index')
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <button class="btn btn-info btn-fill pull-right top-action"
                            data-toggle="modal" data-target="#modal-suit"
                            data-load="{{ route('admin.suits.create') }}"
                    >
                        <i class="icon pe-7s-plus"></i>&nbsp;Novo
                    </button>
                    <h4 class="title">Naipes</h4>
                </div>
                <div class="content table-responsive table-full-width">
                    @controller('Admin\SuitController@index')
                </div>
            </div>
        </div>
    </div>
@endsection