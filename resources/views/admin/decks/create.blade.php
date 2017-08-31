@include('admin.decks.form', [
    'id' => null,
    'route' => route('admin.decks.store'),
    'method' => 'post',
    'title' => 'Criando Baralho',
    'deck' => isset($deck) ? $deck : []
])