@include('admin.decks.form', [
    'id' => $id,
    'route' => route('admin.decks.update', ['id' => $id]),
    'method' => 'put',
    'title' => 'Editando Baralho',
    'deck' => $deck
])