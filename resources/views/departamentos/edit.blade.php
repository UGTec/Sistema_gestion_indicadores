@extends('layouts.app')

@section('title', 'Editar Departamento')
@section('subtitle', 'Modificar Información del Departamento')
@section('content_header_title', 'Editar Departamento')
@section('content_header_subtitle', 'Formulario para editar un departamento existente')

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
    <x-adminlte-card class="shadow" title="Editar Departamento" theme="primary" icon="fas fa-lg fa-building" collapsible maximizable>
        <x-slot name="toolsSlot">
            <a href="{{ route('departamentos.index') }}" class="btn btn-xs btn-secondary" title="Volver al Listado">
                <i class="fas fa-arrow-left"></i> Volver al Listado
            </a>
        </x-slot>
        <form action="{{ route('departamentos.update', $departamento->cod_departamento) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="cod_departamento">Código</label>
                    <input type="number" class="form-control @error('cod_departamento') is-invalid @enderror" id="cod_departamento" name="cod_departamento"
                           value="{{ $departamento->cod_departamento }}" readonly>
                    @error('cod_departamento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-7">
                    <label for="departamento">Nombre Departamento</label>
                    <input type="text" class="form-control @error('departamento') is-invalid @enderror" id="departamento" name="departamento"
                           value="{{ $departamento->departamento }}" required>
                    @error('departamento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="cod_division">División</label>
                    <select class="form-control @error('cod_division') is-invalid @enderror" id="cod_division" name="cod_division" required>
                        <option value="">Seleccione una división</option>
                        @foreach($divisions as $division)
                            <option value="{{ $division->cod_division }}"
                                {{ $departamento->cod_division == $division->cod_division ? 'selected' : '' }}>
                                {{ $division->division }}
                            </option>
                        @endforeach
                    </select>
                    @error('cod_division')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                @can('departamentos.editar')
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                @endcan
                <a href="{{ route('departamentos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </x-adminlte-card>
@stop
