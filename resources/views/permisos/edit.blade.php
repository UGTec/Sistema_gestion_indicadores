@extends('layouts.app')

@section('title', 'Editar Permiso')
@section('subtitle', 'Editar Permiso')
@section('content_header_title', 'Editar Permiso')
@section('content_header_subtitle', 'Modificar los detalles del permiso')


@section('content_body')
<!-- Display any success or error messages -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<!-- Card for editing permission -->
    <x-adminlte-card class="shadow" title="Editar Permiso: {{ $permission->name }}" theme="primary" icon="fas fa-lg fa-lock" collapsible maximizable>
        <x-slot name="toolsSlot">
            <a href="{{ route('permisos.index') }}" class="btn btn-xs btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Permisos
            </a>
        </x-slot>
        <form action="{{ route('permisos.update', $permission->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nombre del Permiso</label>
                <input type="text" class="form-control" id="name" name="name"
                       value="{{ old('name', $permission->name) }}" required>
                <small class="form-text text-muted">Formato: modulo.accion (ej: usuarios.crear)</small>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar
                </button>
                <a href="{{ route('permisos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </x-adminlte-card>
@stop
