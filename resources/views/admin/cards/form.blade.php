<form id="form-card" action="{{ $route }}" method="POST" class="form-horizontal"
      data-ajax="true" data-ajax-refresh=".deck"
>
    {!! method_field($method) !!}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ $title }}</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-img" style="height:245px;">
                    @if(!empty($card['image']))
                        <div class="center-block-absolute">
                            <img src="{{ asset('assets/img/upload/cards/' . $card['image']->basename) }}">
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-sm-8">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Naipe</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="suit_id">
                            <option value="">Não pertence a um naipe</option>
                            @foreach($suits as $suit)
                                <option value="{{ $suit['id'] }}"
                                        {{ (!empty($card['suit_id']) && $suit['id'] == $card['suit_id']) ? ' selected' : '' }}
                                >
                                    {{ $suit['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Ação</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="action_id">
                            <option value="">Não tem ação</option>
                            @foreach($actions as $action)
                                <option value="{{ $action['id'] }}"
                                        {{ (!empty($card['action_id']) && $action['id'] == $card['action_id']) ? ' selected' : '' }}
                                >
                                    {{ $action['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Encaixa Com</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="match">
                            <option value="1" {{ (!empty($card['match']) && $card['match'] == 1) ? ' selected' : '' }}>
                                Nome Ou Naipe
                            </option>
                            <option value="2" {{ (!empty($card['match']) && $card['match'] == 2) ? ' selected' : '' }}>
                                Apenas Nome
                            </option>
                            <option value="3" {{ (!empty($card['match']) && $card['match'] == 3) ? ' selected' : '' }}>
                                Apenas Naipe
                            </option>
                            <option value="4" {{ (!empty($card['match']) && $card['match'] == 4) ? ' selected' : '' }}>
                                Qualquer
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Pontos</label>
                    <div class="col-sm-10">
                        <input type="number" name="points" min="1" max="30" class="form-control" value="{{ $card['points'] or '1' }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nome</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" placeholder="Nome" value="{{ $card['name'] or '' }}"
                               style="text-transform:uppercase;"
                               maxlength="6">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Imagem</label>
                    <div class="col-sm-10">
                        <input type="file" name="image">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        {!! csrf_field() !!}
        <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-info btn-fill">Salvar</button>
    </div>
</form>