@extends('layouts.app')

@section('title', 'Crear Usuario')
@section('subtitle', 'Nuevo Usuario')
@section('content_header_title', 'Crear Usuario')
@section('content_header_subtitle', 'Formulario para crear un nuevo usuario')

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
    <x-adminlte-card class="shadow" title="Crear Nuevo Usuario" theme="primary" icon="fas fa-lg fa-user-plus" collapsible maximizable>
        {{-- Tools slot for creating a new user --}}
        <x-slot name="toolsSlot">
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary btn-xs" title="Volver a Usuarios">
                <i class="fas fa-arrow-left"></i> Volver a Usuarios
            </a>
        </x-slot>
        {{-- Form for creating a new user --}}
        <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="usuario">Usuario</label>
                        <input type="text" class="form-control @error('usuario') is-invalid @enderror" id="usuario" name="usuario" value="{{ old('usuario') }}" placeholder="Ingrese el nombre de usuario">
                        @error('usuario')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="correo_electronico">Email</label>
                        <input type="email" class="form-control @error('correo_electronico') is-invalid @enderror" id="correo_electronico" name="correo_electronico"  value="{{ old('correo_electronico') }}" placeholder="Ingrese el correo electrónico">
                        @error('correo_electronico')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre"  value="{{ old('nombre') }}" placeholder="Ingrese el nombre">
                        @error('nombre')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="primer_apellido">Primer Apellido</label>
                        <input type="text" class="form-control @error('primer_apellido') is-invalid @enderror" id="primer_apellido" name="primer_apellido"  value="{{ old('primer_apellido') }}" placeholder="Ingrese el primer apellido">
                        @error('primer_apellido')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="segundo_apellido">Segundo Apellido</label>
                        <input type="text" class="form-control @error('segundo_apellido') is-invalid @enderror" id="segundo_apellido" name="segundo_apellido" value="{{ old('segundo_apellido') }}" placeholder="Ingrese el segundo apellido">
                        @error('segundo_apellido')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="cod_departamento">Departamento</label>
                        <select class="form-control @error('cod_departamento') is-invalid @enderror" id="cod_departamento" name="cod_departamento" >
                            <option value="">Seleccione un departamento</option>
                            @foreach($departamentos as $departamento)
                                <option value="{{ $departamento->cod_departamento }}">{{ $departamento->departamento }}</option>
                            @endforeach
                        </select>
                        @error('cod_departamento')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="cod_estado_usuario">Estado</label>
                        <select class="form-control @error('cod_estado_usuario') is-invalid @enderror" id="cod_estado_usuario" name="cod_estado_usuario" >
                            <option value="">Seleccione un estado</option>
                            @foreach($estados as $estado)
                                <option value="{{ $estado->cod_estado_usuario }}">{{ $estado->estado_usuario }}</option>
                            @endforeach
                        </select>
                        @error('cod_estado_usuario')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="rol">Perfil</label>
                        <select class="form-control @error('rol') is-invalid @enderror" id="rol" name="rol" >
                            <option value="">Seleccione un perfil</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('rol')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Ingrese la contraseña">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password_confirmation">Confirmar Contraseña</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Confirme la contraseña">
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                </div>
            </form>
    </x-adminlte-card>
@stop
