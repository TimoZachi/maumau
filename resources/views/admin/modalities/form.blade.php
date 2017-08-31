<form id="form-modality" action="{{ $route }}" method="POST" class="form-horizontal"
      data-ajax="true" data-ajax-refresh="#table-modalities"
>
    {!! method_field($method) !!}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ $title }}</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-9">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nome</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" placeholder="Nome" value="{{ $modality['name'] or '' }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Baralho</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="deck_id">
                            <option value="">Selecionar...</option>
                            @foreach($decks as $deck)
                                <option value="{{ $deck['id'] }}"
                                        {{ (!empty($modality['deck_id']) && $deck['id'] == $modality['deck_id']) ? ' selected' : '' }}
                                >
                                    {{ $deck['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">N baralhos</label>
                    <div class="col-sm-10">
                        <input type="number" name="decks_count" class="form-control" value="{{ $modality['decks_count'] or '1' }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Descrição</label>
                    <div class="col-sm-10">
                        <textarea name="description" class="form-control">{{ $modality['description'] or '' }}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <label class="checkbox">
                    <input type="checkbox" name="main" data-toggle="checkbox" value="1" data-toggle="checkbox"
                            {{ (isset($modality['main']) && $modality['main']) ? ' checked' : '' }}>
                    Principal
                </label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        {!! csrf_field() !!}
        <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-info btn-fill">Salvar</button>
    </div>
</form>
<script>
    $('[data-toggle="checkbox"]').checkbox();
</script>