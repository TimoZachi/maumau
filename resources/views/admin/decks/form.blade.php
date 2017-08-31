<form id="form-deck" action="{{ $route }}" method="POST" class="form-horizontal"
      data-ajax="true" data-ajax-refresh="#table-decks"
>
    {!! method_field($method) !!}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ $title }}</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label class="col-sm-2 control-label">Nome</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" placeholder="Nome" value="{{ $deck['name'] or '' }}">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        {!! csrf_field() !!}
        <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-info btn-fill">Salvar</button>
    </div>
</form>