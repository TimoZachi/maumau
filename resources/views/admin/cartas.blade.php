@extends('admin.layout')

@section('title', 'Cartas')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <button class="btn btn-info btn-fill pull-right top-action"
                            data-toggle="modal" data-target="#modal-card"
                            data-load="{{ route('admin.cards.create') }}"
                    >
                        <i class="icon pe-7s-plus"></i>&nbsp;Nova
                    </button>
                    <h4 class="title">Cartas</h4>
                </div>
                <div class="content">
                    @controller('Admin\CardController@index')
                </div>

            </div>
        </div>
    </div>
@endsection