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
        <form method="POST" action="{{ route('indicadores-mensuales.store', $indicador) }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group row">
                <label for="mes" class="col-md-4 col-form-label text-md-right">Mes</label>
                <div class="col-md-6">
                    <select id="mes" class="form-control @error('mes') is-invalid @enderror" name="mes" >
                        @foreach(range(1, $currentMonth) as $month)
                            @php
                                $disabled = true; // Por defecto deshabilitado
                                if ($month == $currentMonth) {
                                    $disabled = false; // mes actual seleccionable
                                } elseif ($month == $previousMonth && !$existsPrevMonth) {
                                    $disabled = false; // mes anterior habilitado solo si no tiene registro
                                }
                            @endphp
                            <option value="{{ $month }}"
                                {{ old('mes') == $month ? 'selected' : '' }}
                                {{ $disabled ? 'disabled' : '' }}>
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
                <label for="numerador" class="col-md-4 col-form-label text-md-right">{{ $indicador->parametro1 }}</label>
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
                <label for="denominador" class="col-md-4 col-form-label text-md-right">{{ $indicador->parametro2 }}</label>
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

            <div class="form-group row">
                <label for="archivos" class="col-md-4 col-form-label text-md-right">Nuevos Archivos</label>
                <div class="col-md-6">
                    <input type="file" id="archivos" class="form-control-file @error('archivos') is-invalid @enderror"
                        name="archivos[]" multiple>
                    <small class="form-text text-muted">
                        Puede seleccionar múltiples archivos (Máximo 10MB en total)
                    </small>
                    @error('archivos')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @error('archivos.*')
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

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Validación de tamaño máximo de archivos (10MB)
            const fileInput = document.getElementById('archivos');
            const maxSize = 10 * 1024 * 1024; // 10MB en bytes

            fileInput.addEventListener('change', function() {
                const files = this.files;
                let totalSize = 0;

                for (let i = 0; i < files.length; i++) {
                    totalSize += files[i].size;
                }

                if (totalSize > maxSize) {
                    alert('El tamaño total de los archivos no puede exceder los 10MB');
                    this.value = ''; // Limpiar la selección
                }
            });
        });
    </script>
@endpush
