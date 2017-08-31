@include('admin.cards.form', [
    'id' => null,
    'route' => route('admin.cards.store'),
    'method' => 'post',
    'title' => 'Criando Carta',
    'card' => isset($card) ? $card : []
])