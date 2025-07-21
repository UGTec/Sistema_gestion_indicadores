@extends('layouts.app')

@section('title', 'Editar Estado de Usuario')
@section('subtitle', 'Modificar Estado Existente')
@section('content_header_title', 'Editar Estado de Usuario')
@section('content_header_subtitle', 'Actualiza los detalles del estado de usuario')

@section('content_body')
    <x-adminlte-card class="shadow" title="Editar Estado de Usuario" theme="primary" icon="fas fa-lg fa-edit" collapsible maximizable>
        <x-slot name="toolsSlot">
            <a href="{{ route('estados.index') }}" class="btn btn-xs btn-secondary" title="Volver a Estados">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </x-slot>
        <form action="{{ route('estados.update', $estado->cod_estado_usuario) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="cod_estado_usuario">Código</label>
                    <input type="number" class="form-control" id="cod_estado_usuario"
                           name="cod_estado_usuario" value="{{ $estado->cod_estado_usuario }}" readonly>
                </div>
                <div class="form-group col-md-10">
                    <label for="estado_usuario">Nombre del Estado</label>
                    <input type="text" class="form-control" id="estado_usuario"
                           name="estado_usuario" value="{{ $estado->estado_usuario }}" required>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar
                </button>
                <a href="{{ route('estados.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </x-adminlte-card>
@stop
