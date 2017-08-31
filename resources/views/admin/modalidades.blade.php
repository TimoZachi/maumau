@extends('admin.layout')

@section('title', 'Modalidades')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <button class="btn btn-info btn-fill pull-right top-action"
                            data-toggle="modal" data-target="#modal-modality"
                            data-load="{{ route('admin.modalities.create') }}"
                    >
                        <i class="icon pe-7s-plus"></i>&nbsp;Nova
                    </button>
                    <h4 class="title">Modalidades</h4>
                </div>
                <div class="content table-responsive table-full-width">
                    @controller('Admin\ModalityController@index')
                </div>
            </div>
        </div>
    </div>
@endsection