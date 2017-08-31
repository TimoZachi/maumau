@include('admin.suits.form', [
    'id' => null,
    'route' => route('admin.suits.store'),
    'method' => 'post',
    'title' => 'Criando Naipe',
    'suit' => isset($suit) ? $suit : []
])