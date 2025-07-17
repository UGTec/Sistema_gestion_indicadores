@extends('layouts.app')

@section('title', 'Detalles del Departamento')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Detalles del Departamento</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6>Información Básica</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Código:</strong> {{ $departamento->cod_departamento }}
                    </li>
                    <li class="list-group-item">
                        <strong>Departamento:</strong> {{ $departamento->departamento }}
                    </li>
                    <li class="list-group-item">
                        <strong>División:</strong> {{ $departamento->division->division ?? 'N/A' }}
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <h6>Usuarios Asociados ({{ $departamento->usuarios->count() }})</h6>
                @if($departamento->usuarios->count() > 0)
                    <ul class="list-group">
                        @foreach($departamento->usuarios as $usuario)
                        <li class="list-group-item">
                            {{ $usuario->nombre }} {{ $usuario->primer_apellido }}
                            <span class="badge badge-{{ $usuario->cod_estado_usuario == 1 ? 'success' : 'danger' }} float-right">
                                {{ $usuario->estado->estado_usuario }}
                            </span>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <div class="alert alert-info">No hay usuarios asociados a este departamento</div>
                @endif
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('departamentos.edit', $departamento->cod_departamento) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('departamentos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
</div>
@endsection
