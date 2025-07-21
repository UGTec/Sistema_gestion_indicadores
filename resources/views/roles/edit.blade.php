@extends('layouts.app')

@section('title', 'Editar Perfil')
@section('subtitle', 'Editar Perfil')
@section('content_header_title', 'Editar Perfil')
@section('content_header_subtitle', 'Modificar los permisos del perfil')

@section('content_body')
    <!-- Display any success or error messages -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <x-adminlte-card class="shadow" title="Editar Perfil: {{ $role->name }}" theme="primary" icon="fas fa-lg fa-user-edit" collapsible maximizable>
        <x-slot name="toolsSlot">
            <a href="{{ route('roles.index') }}" class="btn btn-xs btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Perfiles
            </a>
        </x-slot>
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nombre del Perfil</label>
                <input type="text" class="form-control" id="name" name="name"
                       value="{{ old('name', $role->name) }}" required>
            </div>

            <div class="form-group">
                <label>Permisos</label>
                <div class="row">
                    @foreach($permissions as $module => $modulePermissions)
                    <div class="col-md-6 mb-4">
                        <x-adminlte-card title="{{ ucfirst($module) }}" theme="info" icon="fas fa-lg fa-lock" collapsible>
                            @foreach($modulePermissions as $permission)
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input"
                                    id="permission-{{ $permission->id }}"
                                    name="permissions[]"
                                    value="{{ $permission->id }}"
                                    @if(in_array($permission->id, $rolePermissions)) checked @endif>
                                <label class="custom-control-label" for="permission-{{ $permission->id }}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                            @endforeach
                        </x-adminlte-card>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar
                </button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </x-adminlte-card>
@stop
