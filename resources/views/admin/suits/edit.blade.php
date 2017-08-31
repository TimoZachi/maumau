@include('admin.suits.form', [
    'id' => $id,
    'route' => route('admin.suits.update', ['id' => $id]),
    'method' => 'put',
    'title' => 'Editando Naipe',
    'suit' => $suit
])