<table id="table-suits" class="table table-hover table-striped" data-refresh="{{ route('admin.suits.index') }}">
    <thead>
        <th width="40">ID</th>
        <th>Nome</th>
        <th>Ícone</th>
        <th>Cor</th>
        <th width="100" class="text-right">Ação</th>
    </thead>
    <tbody class="ajax-content">
        @forelse($suits as $suit)
            <tr>
                <td>{{ $suit['id'] }}</td>
                <td>{{ $suit['name'] }}</td>
                <td>
                    <img src="{{ asset('assets/img/upload/suits/' . $suit['icon']) }}" width="40">
                </td>
                <td>
                    <div class="color-sample" style="background-color:{{ $suit['color'] }};"></div>
                </td>
                <td class="td-actions text-right">
                    <button type="button" rel="tooltip" class="btn btn-info btn-simple btn-xs action" title="Editar Baralho"
                            data-toggle="modal" data-target="#modal-suit"
                            data-load="{{ route('admin.suits.edit', ['id' => $suit['id']]) }}"
                    >
                        <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" rel="tooltip" class="btn btn-danger btn-simple btn-xs action delete" title="Excluir"
                            data-toggle="modal" data-target="#modal-suit-delete"
                            data-action="{{ route('admin.suits.destroy', ['id' => $suit['id']]) }}"
                    >
                        <i class="fa fa-times"></i>
                    </button>
                </td>
            </tr>
        @empty
            <tr class="none">
                <td colspan="5">
                    <span>Nenhum naipe cadastrado</span>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@section('modals')
    @parent

    <div id="modal-suit" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content card">
            </div>
        </div>
    </div>
    <div id="modal-suit-delete" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content card">
                <form id="form-suit-delete" action="{{ route('admin.suits.destroy', ['id' => '00']) }}" method="POST" class="form-horizontal"
                      data-ajax="true" data-ajax-refresh="#table-decks"
                >
                    {!! method_field('delete') !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Excluir Naipe</h4>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que deseja excluir este Naipe? Se fizer isso, as cartas que tem esse naipe ficarão sem naipe.</p>
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