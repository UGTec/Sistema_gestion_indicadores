@extends('layouts.app')

@section('title', 'Crear Estado de Usuario')
@section('subtitle', 'Nuevo Estado')
@section('content_header_title', 'Crear Nuevo Estado')
@section('content_header_subtitle', 'Definir un nuevo estado para los usuarios')

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
    <x-adminlte-card class="shadow" title="Crear Nuevo Estado" theme="primary" icon="fas fa-lg fa-plus">
        <x-slot name="toolsSlot">
            <a href="{{ route('estados.index') }}" class="btn btn-xs btn-secondary" title="Volver a Estados">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </x-slot>
        <form action="{{ route('estados.store') }}" method="POST">
            @csrf

            <div class="form-row">
                {{-- <div class="form-group col-md-2">
                    <label for="cod_estado_usuario">Código</label>
                    <input type="number" class="form-control @error('cod_estado_usuario') is-invalid @enderror" id="cod_estado_usuario" name="cod_estado_usuario" required>
                    @error('cod_estado_usuario')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Número único identificador</small>
                </div> --}}
                <div class="form-group col-md-12">
                    <label for="estado_usuario">Nombre del Estado</label>
                    <input type="text" class="form-control @error('estado_usuario') is-invalid @enderror" id="estado_usuario" name="estado_usuario">
                    @error('estado_usuario')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Ej: Activo, Inactivo, Suspendido</small>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <a href="{{ route('estados.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </x-adminlte-card>
@stop
