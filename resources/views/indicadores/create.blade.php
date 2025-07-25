@extends('layouts.app')

@section('title', 'Crear Nuevo Indicador')
@section('subtitle', 'Formulario para crear un nuevo indicador')
@section('content_header_title', 'Crear Indicador')
@section('content_header_subtitle', 'Complete el formulario para registrar un nuevo indicador en el sistema.')

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
    <x-adminlte-card class="shadow" title="Crear Nuevo Indicador" theme="primary" icon="fas fa-plus" collapsible maximizable>
        <x-slot name="toolsSlot">
            <a href="{{ route('indicadores.index') }}" class="btn btn-xs btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a la lista
            </a>
        </x-slot>
        <form action="{{ route('indicadores.store') }}" method="POST">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="cod_indicador">Código</label>
                        <input type="number" class="form-control @error('cod_indicador') is-invalid @enderror" id="cod_indicador" name="cod_indicador" required>
                        <small class="form-text text-muted">Número único identificador</small>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="cod_tipo_indicador">Tipo de Indicador</label>
                        <select class="form-control @error('cod_tipo_indicador') is-invalid @enderror" id="cod_tipo_indicador" name="cod_tipo_indicador" required>
                            <option value="">Seleccione un tipo</option>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo->cod_tipo_indicador }}">{{ $tipo->tipo_indicador }} - {{ $tipo->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="cod_usuario">Responsable</label>
                        <select class="form-control @error('cod_usuario') is-invalid @enderror" id="cod_usuario" name="cod_usuario" required>
                            <option value="">Seleccione un responsable</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->cod_usuario }}">{{ $usuario->nombre }} {{ $usuario->primer_apellido }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="indicador">Nombre del Indicador</label>
                    <textarea class="form-control @error('indicador') is-invalid @enderror" id="indicador" name="indicador" rows="2" required></textarea>
                </div>

                <div class="form-group">
                    <label for="objetivo">Objetivo</label>
                    <textarea class="form-control @error('objetivo') is-invalid @enderror" id="objetivo" name="objetivo" rows="2" required></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="parametro1">Parámetro 1</label>
                        <input type="text" class="form-control @error('parametro1') is-invalid @enderror" id="parametro1" name="parametro1">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="parametro2">Parámetro 2</label>
                        <input type="text" class="form-control @error('parametro2') is-invalid @enderror" id="parametro2" name="parametro2">
                    </div>
                </div>

                <div class="form-group">
                    <label for="meta">Meta (%)</label>
                    <input type="number" class="form-control @error('meta') is-invalid @enderror" id="meta" name="meta" min="0" max="100" step="0.01">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <a href="{{ route('indicadores.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                </div>
            </form>
    </x-adminlte-card>
@stop
