<x-adminlte-card theme="dark" theme-mode="outline" class="shadow elevation-3" title="Editar Usuario: {{ $usuario->nombre }}" icon="fas fa-lg fa-user-edit">
    <form action="{{ route('usuarios.update', $usuario->cod_usuario) }}" method="POST">
        @csrf
        @method('PUT')

        @include('usuarios.form', [
            'usuario' => $usuario,
            'departamentos' => $departamentos,
            'estados' => $estados
        ])

        <x-adminlte-button type="submit" label="Guardar" theme="success" icon="fas fa-lg fa-save"/>
    </form>
</x-adminlte-card>
