<form id="form-card" action="{{ $route }}" method="POST" class="form"
      data-ajax="true"
>
    {!! method_field($method) !!}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">{{ $title }}</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-img" style="height:250px;">
                    @if(!empty($user['avatar']))
                        <div class="center-block-absolute">
                            <img src="{{ asset('assets/img/upload/avatars/' . $user['avatar']->basename) }}">
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-sm-8">
                <div class="form-group">
                    <label class="control-label">Nome</label>
                    <input type="text" class="form-control" name="name" value="{{ $user['name'] or '' }}">
                </div>
                <div class="form-group">
                    <label class="control-label">Email</label>
                    <input type="text" class="form-control" name="email" value="{{ $user['email'] or '' }}">
                </div>
                <div class="form-group">
                    <label class="control-label">Avatar</label>
                    <input type="file" class="form-control" name="avatar">
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