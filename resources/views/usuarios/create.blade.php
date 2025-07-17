@extends('layouts.app')

@section('title', 'Crear Nuevo Usuario')

@section('content')
<div class="">
    <h2 class="">Crear Nuevo Usuario</h2>

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf

        @include('usuarios.form', [
            'usuario' => new App\Models\Usuario,
            'departamentos' => $departamentos,
            'estados' => $estados
        ])

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('usuarios.index') }}" class="btn btn-warning">
                Cancelar
            </a>
            <button type="submit" class="btn btn-success">
                Guardar Usuario
            </button>
        </div>
    </form>
</div>
@endsection
