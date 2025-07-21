@extends('layouts.app')

@section('title', 'Crear Nuevo Perfil')
@section('subtitle', 'Crear Nuevo Perfil')
@section('content_header_title', 'Crear Perfil')
@section('content_header_subtitle', 'Definir un nuevo perfil con permisos específicos')

@section('content_body')
    {{-- Display validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        {{-- Setup data for datatables --}}
    <x-adminlte-card class="shadow" title="Crear Nuevo Perfil" theme="primary" icon="fas fa-lg fa-user-plus" collapsible maximizable>
        <x-slot name="toolsSlot">
            <a href="{{ route('roles.index') }}" class="btn btn-xs btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a Perfiles
            </a>
        </x-slot>

        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nombre del Rol</label>
                <input type="text" class="form-control" id="name" name="name" required>
                <small class="form-text text-muted">Ej: Administrador, Editor, etc.</small>
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
                                        value="{{ $permission->id }}">
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
                    <i class="fas fa-save"></i> Guardar
                </button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </x-adminlte-card>
@stop
