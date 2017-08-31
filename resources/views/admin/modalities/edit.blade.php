@include('admin.modalities.form', [
    'id' => $id,
    'route' => route('admin.modalities.update', ['id' => $id]),
    'method' => 'put',
    'title' => 'Editando Modalidade',
    'modality' => $modality
])