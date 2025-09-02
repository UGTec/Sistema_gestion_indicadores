@extends('layouts.app')

@section('title', 'Detalles del Departamento')
@section('subtitle', 'Información del Departamento')
@section('content_header_title', 'Detalles del Departamento')
@section('content_header_subtitle', 'Información detallada del departamento seleccionado')

@section('content_body')
    <x-adminlte-card class="shadow" title="Detalles del Departamento" theme="primary" icon="fas fa-lg fa-building">
        <x-slot name="toolsSlot">
            <a href="{{ route('departamentos.index') }}" class="btn btn-xs btn-secondary" title="Volver al Listado">
                <i class="fas fa-arrow-left"></i> Volver al Listado
            </a>
        </x-slot>
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
                            {{ $usuario->nombreCompleto() }}
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
    </x-adminlte-card>
@stop
