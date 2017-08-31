<div class="deck clearfix ajax-content"
     data-refresh="{{ route('admin.cards.index') }}"
>
    @forelse($cards as $card)
        @include('card-template', ['card' => $card, 'tag' => 'div', 'icons' => true])
    @empty
        <div class="none">
            <span>Nenhuma carta cadastrada</span>
        </div>
    @endforelse
</div>

@section('modals')
    @parent

    <div id="modal-card" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content card">
            </div>
        </div>
    </div>
    <div id="modal-card-delete" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content card">
                <form id="form-card-delete" action="{{ route('admin.cards.destroy', ['id' => '00']) }}" method="POST" class="form-horizontal"
                      data-ajax="true" data-ajax-refresh=".deck"
                >
                    {!! method_field('delete') !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Excluir Carta</h4>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que deseja excluir esta Carta?</p>
                    </div>
                    <div class="modal-footer">
                        {!! csrf_field() !!}
                        <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-info btn-fill">Excluir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection