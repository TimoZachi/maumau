<table id="table-decks" class="table table-hover table-striped" data-refresh="{{ route('admin.decks.index') }}">
    <thead>
        <th width="40">ID</th>
        <th>Nome</th>
        <th>Naipes</th>
        <th>Nº de Cartas</th>
        <th width="120" class="text-right">Ação</th>
    </thead>
    <tbody class="ajax-content">
        @forelse($decks as $deck)
            <tr>
                <td>{{ $deck['id'] }}</td>
                <td>{{ $deck['name'] }}</td>
                <td>{{ $deck['suits_count'] }}</td>
                <td>{{ $deck['cards_count'] }}</td>
                <td class="td-actions text-right">
                    <a rel="tooltip" class="btn btn-info btn-simple btn-xs action" title="Associar Cartas"
                       href="{{ route('admin.baralhos-associar-cartas', ['id' => $deck['id']]) }}"
                    >
                        <i class="pe-7s-albums"></i>
                    </a>
                    <button type="button" rel="tooltip" class="btn btn-info btn-simple btn-xs action" title="Editar Baralho"
                            data-toggle="modal" data-target="#modal-deck"
                            data-load="{{ route('admin.decks.edit', ['id' => $deck['id']]) }}"
                    >
                        <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" rel="tooltip" class="btn btn-danger btn-simple btn-xs action delete" title="Excluir"
                            data-toggle="modal" data-target="#modal-deck-delete"
                            data-action="{{ route('admin.decks.destroy', ['id' => $deck['id']]) }}"
                    >
                        <i class="fa fa-times"></i>
                    </button>
                </td>
            </tr>
        @empty
            <tr class="none">
                <td colspan="5">
                    <span>Nenhum baralho cadastrado</span>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@section('modals')
    @parent

    <div id="modal-deck" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content card">
            </div>
        </div>
    </div>
    <div id="modal-deck-delete" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content card">
                <form id="form-deck-delete" action="{{ route('admin.decks.destroy', ['id' => '00']) }}" method="POST" class="form-horizontal"
                      data-ajax="true" data-ajax-refresh="#table-decks"
                >
                    {!! method_field('delete') !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Excluir Baralho</h4>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que deseja excluir este Baralho?</p>
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