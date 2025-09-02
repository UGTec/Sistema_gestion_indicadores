@extends('layouts.app')

@section('title', 'Detalles del Estado')
@section('subtitle', 'Estado de Usuario')
@section('content_header_title', 'Detalles del Estado')
@section('content_header_subtitle', 'Información del Estado de Usuario')

@section('content_body')
    <x-adminlte-card class="shadow" title="Detalles del Estado" theme="primary" icon="fas fa-lg fa-info-circle">
        <x-slot name="toolsSlot">
            <a href="{{ route('estados.index') }}" class="btn btn-xs btn-secondary" title="Volver a Estados">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </x-slot>
        <div class="row">
            <div class="col-md-6">
                <h6>Información Básica</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Código:</strong> {{ $estado->cod_estado_usuario }}
                    </li>
                    <li class="list-group-item">
                        <strong>Estado:</strong>
                        <span class="badge badge-{{ $estado->cod_estado_usuario == 1 ? 'success' : 'danger' }}">
                            {{ $estado->estado_usuario }}
                        </span>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <h6>Usuarios con este estado ({{ $estado->usuarios->count() }})</h6>
                @if($estado->usuarios->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Nombre</th>
                                    <th>Departamento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($estado->usuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->usuario }}</td>
                                    <td>{{ $usuario->nombreCompleto() }}</td>
                                    <td>{{ $usuario->departamento->departamento ?? 'N/A' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">No hay usuarios con este estado</div>
                @endif
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('estados.edit', $estado->cod_estado_usuario) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('estados.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
    </x-adminlte-card>
@stop
