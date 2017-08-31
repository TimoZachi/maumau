@include('users.form', [
    'id' => $id,
    'route' => route('users.update'),
    'method' => 'PUT',
    'title' => 'Meu Perfil',
    'user' => $user
])