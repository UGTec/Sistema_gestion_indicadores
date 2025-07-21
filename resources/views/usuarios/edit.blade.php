@extends('layouts.app')

@section('title', 'Editar Usuario')
@section('subtitle', 'Modificar Usuario Existente')
@section('content_header_title', 'Editar Usuario')
@section('content_header_subtitle', 'Formulario para editar un usuario existente')

@section('content_body')
    {{-- Display success message if available --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    {{-- Display error messages if any --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- Card for editing user details --}}
    <x-adminlte-card class="shadow" title="Editar Usuario" theme="primary" icon="fas fa-lg fa-user-edit" collapsible maximizable>
        {{-- Tools slot for navigation --}}
        <x-slot name="toolsSlot">
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary btn-xs" title="Volver a Usuarios">
                <i class="fas fa-arrow-left"></i> Volver a Usuarios
            </a>
        </x-slot>
        {{-- Display user details --}}
        <form action="{{ route('usuarios.update', $usuario->cod_usuario) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="usuario">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" value="{{ $usuario->usuario }}" required disabled>
                </div>
                <div class="form-group col-md-6">
                    <label for="correo_electronico">Email</label>
                    <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" value="{{ $usuario->correo_electronico }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $usuario->nombre }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="primer_apellido">Primer Apellido</label>
                    <input type="text" class="form-control" id="primer_apellido" name="primer_apellido" value="{{ $usuario->primer_apellido }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="segundo_apellido">Segundo Apellido</label>
                    <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido" value="{{ $usuario->segundo_apellido }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="cod_departamento">Departamento</label>
                    <select class="form-control" id="cod_departamento" name="cod_departamento" required>
                        <option value="">Seleccione un departamento</option>
                        @foreach($departamentos as $departamento)
                            <option value="{{ $departamento->cod_departamento }}" {{ $usuario->cod_departamento == $departamento->cod_departamento ? 'selected' : '' }}>
                                {{ $departamento->departamento }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="cod_estado_usuario">Estado</label>
                    <select class="form-control" id="cod_estado_usuario" name="cod_estado_usuario" required>
                        <option value="">Seleccione un estado</option>
                        @foreach($estados as $estado)
                            <option value="{{ $estado->cod_estado_usuario }}" {{ $usuario->cod_estado_usuario == $estado->cod_estado_usuario ? 'selected' : '' }}>
                                {{ $estado->estado_usuario }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="rol">Perfil</label>
                    <select class="form-control" id="rol" name="rol" required>
                        <option value="">Seleccione un perfil</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ $usuario->roles->contains('name', $role->name) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Dejar en blanco para no cambiar">
                    <small class="form-text text-muted">Mínimo 8 caracteres. Solo completa si deseas cambiar la contraseña.</small>
                </div>
                <div class="form-group col-md-6">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Dejar en blanco para no cambiar">
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar
                </button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </x-adminlte-card>
@stop
