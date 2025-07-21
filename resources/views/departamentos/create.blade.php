@extends('layouts.app')

@section('title', 'Crear Departamento')
@section('subtitle', 'Nuevo Departamento')
@section('content_header_title', 'Crear Departamento')
@section('content_header_subtitle', 'Formulario para crear un nuevo departamento')

@section('content_body')
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
    {{-- Card for creating a new department --}}
    <x-adminlte-card class="shadow" title="Crear Nuevo Departamento" theme="primary" icon="fas fa-lg fa-building">
        <x-slot name="toolsSlot">
            <a href="{{ route('departamentos.index') }}" class="btn btn-xs btn-secondary" title="Volver al Listado">
                <i class="fas fa-arrow-left"></i> Volver al Listado
            </a>
        </x-slot>
        <form action="{{ route('departamentos.store') }}" method="POST">
            @csrf

            <div class="form-row">
                {{-- <div class="form-group col-md-2">
                    <label for="cod_departamento">Código</label>
                    <input type="number" class="form-control @error('cod_departamento') is-invalid @enderror" id="cod_departamento" name="cod_departamento" required>
                </div> --}}
                <div class="form-group col-md-6">
                    <label for="departamento">Nombre Departamento</label>
                    <input type="text" class="form-control @error('departamento') is-invalid @enderror" id="departamento" name="departamento" value="{{ old('departamento') }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="cod_division">División</label>
                    <select class="form-control @error('cod_division') is-invalid @enderror" id="cod_division" name="cod_division" required>
                        <option value="">Seleccione una división</option>
                        @foreach($divisions as $division)
                            <option value="{{ $division->cod_division }}">{{ $division->division }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <a href="{{ route('departamentos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </x-adminlte-card>
@stop
