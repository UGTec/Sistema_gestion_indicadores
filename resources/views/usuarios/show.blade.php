@extends('layouts.app')

@section('subtitle', 'Detalles del Usuario')
@section('content_header_title', 'Detalles del Usuario')
@section('content_header_subtitle', '')

@section('content_body')
    <x-adminlte-card class="shadow" title="Detalles del Usuario" theme="primary" icon="fas fa-lg fa-user" collapsible maximizable>
        {{-- <div class="row">
            <div class="col-md-6">
                <p><strong>Nombre Completo:</strong> {{ $usuario->nombre . ' ' . $usuario->primer_apellido . ' ' . $usuario->segundo_apellido }}</p>
                <p><strong>Correo Electrónico:</strong> {{ $usuario->correo_electronico }}</p>
                <p><strong>Departamento:</strong> {{ $departamento->departamento }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Estado:</strong> {{ $estado->estado_usuario }}</p>
                <p><strong>Código de Usuario:</strong> {{ $usuario->cod_usuario }}</p>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-md-6">
                <h6>Información Básica</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>ID:</strong> {{ $usuario->cod_usuario }}
                    </li>
                    <li class="list-group-item">
                        <strong>Usuario:</strong> {{ $usuario->usuario }}
                    </li>
                    <li class="list-group-item">
                        <strong>Nombre Completo:</strong>
                        {{ $usuario->nombre }} {{ $usuario->primer_apellido }} {{ $usuario->segundo_apellido }}
                    </li>
                    <li class="list-group-item">
                        <strong>Email:</strong> {{ $usuario->correo_electronico }}
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <h6>Información Adicional</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Departamento:</strong> {{ $usuario->departamento->departamento ?? 'N/A' }}
                    </li>
                    <li class="list-group-item">
                        <strong>División:</strong> {{ $usuario->departamento->division->division ?? 'N/A' }}
                    </li>
                    <li class="list-group-item">
                        <strong>Estado:</strong>
                        <span class="badge badge-{{ $usuario->cod_estado_usuario == 1 ? 'success' : 'danger' }}">
                            {{ $usuario->estado->estado_usuario ?? 'N/A' }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('usuarios.edit', $usuario->cod_usuario) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </x-adminlte-card>
@stop
