@include('admin.cards.form', [
    'id' => $id,
    'route' => route('admin.cards.update', ['id' => $id]),
    'method' => 'put',
    'title' => 'Editando Carta',
    'card' => $card
])