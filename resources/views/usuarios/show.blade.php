@extends('layouts.app')

@section('title', 'Detalles del Usuario')
@section('subtitle', 'Información del Usuario')
@section('content_header_title', 'Detalles del Usuario')
@section('content_header_subtitle', 'Información detallada del usuario seleccionado')

@section('content_body')
    {{-- Card to display user details --}}
    <x-adminlte-card class="shadow" title="Detalles del Usuario" theme="primary" icon="fas fa-lg fa-user" collapsible maximizable>
        {{-- Tools slot for navigation --}}
        <x-slot name="toolsSlot">
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary btn-xs" title="Volver a Usuarios">
                <i class="fas fa-arrow-left"></i> Volver a Usuarios
            </a>
        </x-slot>
        {{-- Display user details --}}
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
                    <li class="list-group-item">
                        <strong>Fecha de Creación:</strong> {{ $usuario->created_at->format('d/m/Y H:i') }}
                    </li>
                    <li class="list-group-item">
                        <strong>Última Actualización:</strong> {{ $usuario->updated_at->format('d/m/Y H:i') }}
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
            <div class="col-md-12 mt-3">
                <h6>Roles Asignados</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Roles:</strong>
                        @if($usuario->roles->isEmpty())
                            <span class="badge badge-warning">Sin roles asignados</span>
                        @else
                            @foreach ($usuario->roles as $rol)
                                <span class="badge badge-info">{{ $rol->name }}</span>
                            @endforeach
                        @endif
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
