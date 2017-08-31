<table id="table-modalities" class="table table-hover table-striped" data-refresh="{{ route('admin.modalities.index') }}">
    <thead>
        <th width="40">ID</th>
        <th>Nome</th>
        <th>Baralho</th>
        <th>Descrição</th>
        <th width="100" class="text-right">Ação</th>
    </thead>
    <tbody class="ajax-content">
        @forelse($modalities as $modality)
            <tr>
                <td>{{ $modality['id'] }}</td>
                <td>{{ $modality['name'] }}</td>
                <td>{{ $modality['Deck']['name'] }}</td>
                <td>{{ $modality['description'] }}</td>
                <td class="td-actions text-right">
                    <button type="button" rel="tooltip" class="btn btn-info btn-simple btn-xs action" title="Editar Baralho"
                            data-toggle="modal" data-target="#modal-modality"
                            data-load="{{ route('admin.modalities.edit', ['id' => $modality['id']]) }}"
                    >
                        <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" rel="tooltip" class="btn btn-danger btn-simple btn-xs action delete" title="Excluir"
                            data-toggle="modal" data-target="#modal-modality-delete"
                            data-action="{{ route('admin.modalities.destroy', ['id' => $modality['id']]) }}"
                    >
                        <i class="fa fa-times"></i>
                    </button>
                </td>
            </tr>
        @empty
            <tr class="none">
                <td colspan="5">
                    <span>Nenhuma modalidade cadastrada</span>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@section('modals')
    @parent

    <div id="modal-modality" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content card">
            </div>
        </div>
    </div>
    <div id="modal-modality-delete" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content card">
                <form id="form-modality-delete" action="{{ route('admin.modalities.destroy', ['id' => '00']) }}" method="POST" class="form-horizontal"
                      data-ajax="true" data-ajax-refresh="#table-modalities"
                >
                    {!! method_field('delete') !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Excluir Modalidade</h4>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que deseja excluir esta Modalidade?</p>
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