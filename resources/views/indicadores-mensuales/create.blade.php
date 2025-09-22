@extends('layouts.app')

@section('subtitle', 'Nuevo Registro Mensual')
@section('content_header_title', 'Nuevo Registro Mensual')
@section('content_header_subtitle', 'Crear un nuevo registro mensual para el indicador seleccionado.')

@section('content_body')

    {{-- Mensajes de éxito y error --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <x-adminlte-card class="shadow" theme="primary" title="Nuevo Registro Mensual para: {{ $indicador->indicador }}" icon="fas fa-calendar-plus" collapsible maximizable>
        <x-slot name="toolsSlot">
            <a href="{{ route('indicadores.show', $indicador) }}" class="btn btn-secondary btn-xs" title="Volver">
                <i class="fas fa-fw fa-arrow-left"></i> Volver
            </a>
        </x-slot>
        <form method="POST" action="{{ route('indicadores-mensuales.store', $indicador) }}">
            @csrf

            <div class="form-group row">
                <label for="mes" class="col-md-4 col-form-label text-md-right">Mes</label>
                <div class="col-md-6">
                    <select id="mes" class="form-control @error('mes') is-invalid @enderror" name="mes" >
                        @foreach(range(1, 12) as $month)
                        <option value="{{ $month }}"
                            {{ old('mes', \Carbon\Carbon::now()->month) == $month ? 'selected' : '' }}
                            {{ $month < \Carbon\Carbon::now()->month ? 'disabled' : '' }}>
                            {{ ucfirst(\Carbon\Carbon::create()->month($month)->locale('es')->monthName) }}
                        </option>
                        @endforeach
                    </select>
                    @error('mes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="año" class="col-md-4 col-form-label text-md-right">Año</label>
                <div class="col-md-6">
                    <input id="año" type="number" class="form-control @error('año') is-invalid @enderror"
                        name="año" value="{{ old('año', date('Y')) }}" min="{{ date('Y') }}" max="{{ date('Y')+1 }}" >
                    @error('año')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="numerador" class="col-md-4 col-form-label text-md-right">Numerador</label>
                <div class="col-md-6">
                    <input id="numerador" type="number" step="0.01" class="form-control @error('numerador') is-invalid @enderror"
                        name="numerador" value="{{ old('numerador') }}" >
                    @error('numerador')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="denominador" class="col-md-4 col-form-label text-md-right">Denominador</label>
                <div class="col-md-6">
                    <input id="denominador" type="number" step="0.01" class="form-control @error('denominador') is-invalid @enderror"
                        name="denominador" value="{{ old('denominador') }}" >
                    @error('denominador')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="observaciones" class="col-md-4 col-form-label text-md-right">Observaciones</label>
                <div class="col-md-6">
                    <textarea id="observaciones" class="form-control @error('observaciones') is-invalid @enderror"
                        name="observaciones" rows="3">{{ old('observaciones') }}</textarea>
                    @error('observaciones')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Registro
                    </button>
                </div>
            </div>
        </form>
    </x-adminlte-card>
@stop
