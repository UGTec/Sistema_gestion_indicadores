@extends('layouts.app')

@section('title', 'Editar Indicador')
@section('subtitle', 'Editar Indicador')
@section('content_header_title', 'Editar Indicador')
@section('content_header_subtitle', 'Editar Indicador')

@section('content_body')
    {{-- Display success message if available --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    {{-- Display error messages if any --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- Card for editing the indicator --}}
    <x-adminlte-card class="shadow" title="Editar Indicador {{ $indicador->cod_indicador }}" theme="primary" icon="fas fa-edit" collapsible maximizable>
        <x-slot name="toolsSlot">
            <a href="{{ route('indicadores.index') }}" class="btn btn-secondary btn-xs" title="Volver a Indicadores">
                <i class="fas fa-arrow-left"></i> Volver a Indicadores
            </a>
        </x-slot>
        <form action="{{ route('indicadores.update', $indicador->cod_indicador) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="cod_indicador">Código</label>
                    <input type="number" class="form-control" id="cod_indicador" name="cod_indicador"
                           value="{{ $indicador->cod_indicador }}" readonly>
                </div>
                <div class="form-group col-md-5">
                    <label for="cod_tipo_indicador">Tipo de Indicador</label>
                    <select class="form-control" id="cod_tipo_indicador" name="cod_tipo_indicador" required>
                        <option value="">Seleccione un tipo</option>
                        @foreach($tipos as $tipo)
                            <option value="{{ $tipo->cod_tipo_indicador }}"
                                {{ $indicador->cod_tipo_indicador == $tipo->cod_tipo_indicador ? 'selected' : '' }}>
                                {{ $tipo->tipo_indicador }} - {{ $tipo->descripcion }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-5">
                    <label for="cod_usuario">Responsable</label>
                    <select class="form-control" id="cod_usuario" name="cod_usuario" required>
                        <option value="">Seleccione un responsable</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->cod_usuario }}"
                                {{ $indicador->cod_usuario == $usuario->cod_usuario ? 'selected' : '' }}>
                                {{ $usuario->nombre }} {{ $usuario->primer_apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="indicador">Nombre del Indicador</label>
                <textarea class="form-control" id="indicador" name="indicador" rows="2" required>{{ $indicador->indicador }}</textarea>
            </div>

            <div class="form-group">
                <label for="objetivo">Objetivo</label>
                <textarea class="form-control" id="objetivo" name="objetivo" rows="2" required>{{ $indicador->objetivo }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="parametro1">Parámetro 1</label>
                    <input type="text" class="form-control" id="parametro1" name="parametro1"
                           value="{{ $indicador->parametro1 }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="parametro2">Parámetro 2</label>
                    <input type="text" class="form-control" id="parametro2" name="parametro2"
                           value="{{ $indicador->parametro2 }}">
                </div>
            </div>

            <div class="form-group">
                <label for="meta">Meta (%)</label>
                <input type="number" class="form-control" id="meta" name="meta"
                       value="{{ $indicador->meta }}" min="0" max="100" step="0.01">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar
                </button>
                <a href="{{ route('indicadores.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </x-adminlte-card>
@stop
