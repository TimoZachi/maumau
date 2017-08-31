<form id="form-suit" action="{{ $route }}" method="POST" class="form-horizontal" enctype="multipart/form-data"
      data-ajax="true" data-ajax-refresh="#table-suits"
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
                        <input type="text" name="name" class="form-control" placeholder="Nome" value="{{ $suit['name'] or '' }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Símbolo</label>
                    <div class="col-sm-10">
                        <input type="file" name="icon">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Cor</label>
                    <div class="col-sm-10">
                        <input type="color" name="color" class="colorpicker" {!! !empty($suit['color']) ? ' value="' . $suit['color'] . '"' : '' !!}>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-img">
                    @if(!empty($suit['icon']))
                        <div class="center-block-absolute">
                            <img src="{{ asset('assets/img/upload/suits/' . $suit['icon']->basename) }}">
                        </div>
                    @endif
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