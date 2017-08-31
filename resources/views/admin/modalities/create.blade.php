@include('admin.modalities.form', [
    'id' => null,
    'route' => route('admin.modalities.store'),
    'method' => 'post',
    'title' => 'Criando Modalidade',
    'card' => isset($card) ? $card : []
])