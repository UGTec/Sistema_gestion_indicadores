@extends('layouts.app')

@section('subtitle', 'Revisión Registro Mensual')
@section('content_header_title', 'Revisión Registro Mensual')
@section('content_header_subtitle', 'Revisión del registro mensual para el indicador seleccionado.')

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
    @php
        $puedeEditar = auth()->user()->hasRole('Control de Gestión');
    @endphp
    <x-adminlte-card class="shadow" theme="primary"
        title="Revisión Registro Mensual {{ ucfirst(\Carbon\Carbon::create(null, $mensual->mes)->locale('es')->monthName) }} {{ $mensual->año }} para: {{ $indicador->indicador }}"
        icon="fas fa-calendar-plus" collapsible maximizable>
        <x-slot name="toolsSlot">
            <a href="{{ route('indicadores.show', $indicador) }}" class="btn btn-secondary btn-xs" title="Volver">
                <i class="fas fa-fw fa-arrow-left"></i> Volver
            </a>
        </x-slot>
        <form method="POST" action="{{ route('indicadores-mensuales.updateRevisar', [$indicador, $mensual]) }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                {{-- ============================================= --}}
                {{-- PRIMERA COLUMNA: Select 'Proceso' y Selects 'Condicional' (IZQUIERDA) --}}
                {{-- La columna usa col-md-6 (media columna) --}}
                {{-- ============================================= --}}
                <div class="col-md-6">

                    {{-- 1. SELECT Proceso (Mantenido) --}}
                    <div class="form-group row">
                        <label for="proceso" class="col-md-4 col-form-label text-md-right">Proceso Estratégico</label>
                        <div class="col-md-6">
                            <select id="cod_proceso_estrategico" {{ $puedeEditar ? '' : 'disabled' }} class="form-control @error('proceso') is-invalid @enderror" name="cod_proceso_estrategico">
                                <option value="">Seleccione un proceso</option>
                                @foreach ($procesos as $proceso)
                                    <option
                                        value="{{ $proceso->id }}"
                                        @selected(old('cod_proceso_estrategico', $mensual->cod_proceso_estrategico) == $proceso->id)
                                    >
                                        {{ $proceso->nombre_proceso }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cod_proceso_estrategico')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <hr class="mt-2 mb-2"> {{-- Separador visual --}}

                    {{-- 2. SELECT Condicional Oportunidad --}}
                    <div class="form-group row">
                        <label for="condicional_oportunidad" class="col-md-4 col-form-label text-md-right">Condicional Oportunidad</label>
                        <div class="col-md-6">
                            <select id="condicional_oportunidad" {{ $puedeEditar ? '' : 'disabled' }}
                                    class="form-control @error('condicional_oportunidad') is-invalid @enderror"
                                    name="condicional_oportunidad">
                                <option value="">Seleccione una condición</option>
                                @foreach ($condiciones as $condicional)
                                    <option
                                        value="{{ $condicional->cod_condicional }}"
                                        @selected(old('condicional_oportunidad', $mensual->condicional_oportunidad) == $condicional->cod_condicional)>
                                        {{ $condicional->condicional }}
                                    </option>
                                @endforeach
                            </select>
                            @error('condicional_oportunidad')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- 3. SELECT Condicional Completitud --}}
                    <div class="form-group row">
                        <label for="condicional_completitud" class="col-md-4 col-form-label text-md-right">Condicional Completitud</label>
                        <div class="col-md-6">
                            <select id="condicional_completitud" {{ $puedeEditar ? '' : 'disabled' }}
                                    class="form-control @error('condicional_completitud') is-invalid @enderror"
                                    name="condicional_completitud">
                                <option value="">Seleccione una condición</option>
                                @foreach ($condiciones as $condicional)
                                    <option
                                        value="{{ $condicional->cod_condicional }}"
                                        @selected(old('condicional_completitud', $mensual->condicional_completitud) == $condicional->cod_condicional)>
                                        {{ $condicional->condicional }}
                                    </option>
                                @endforeach
                            </select>
                            @error('condicional_completitud')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- 4. SELECT Condicional Progreso --}}
                    <div class="form-group row">
                        <label for="condicional_progreso" class="col-md-4 col-form-label text-md-right">Condicional Progreso</label>
                        <div class="col-md-6">
                            <select id="condicional_progreso" {{ $puedeEditar ? '' : 'disabled' }}
                                    class="form-control @error('condicional_progreso') is-invalid @enderror"
                                    name="condicional_progreso">
                                <option value="">Seleccione una condición</option>
                                @foreach ($condiciones as $condicional)
                                    <option
                                        value="{{ $condicional->cod_condicional }}"
                                        @selected(old('condicional_progreso', $mensual->condicional_progreso) == $condicional->cod_condicional)>
                                        {{ $condicional->condicional }}
                                    </option>
                                @endforeach
                            </select>
                            @error('condicional_progreso')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- 5. SELECT Condicional Riesgo --}}
                    <div class="form-group row">
                        <label for="condicional_riesgo" class="col-md-4 col-form-label text-md-right">Condicional Riesgo</label>
                        <div class="col-md-6">
                            <select id="condicional_riesgo" {{ $puedeEditar ? '' : 'disabled' }}
                                    class="form-control @error('condicional_riesgo') is-invalid @enderror"
                                    name="condicional_riesgo">
                                <option value="">Seleccione una condición</option>
                                @foreach ($condiciones as $condicional)
                                    <option
                                        value="{{ $condicional->cod_condicional }}"
                                        @selected(old('condicional_riesgo', $mensual->condicional_riesgo) == $condicional->cod_condicional)>
                                        {{ $condicional->condicional }}
                                    </option>
                                @endforeach
                            </select>
                            @error('condicional_riesgo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>

                {{-- ============================================================== --}}
                {{-- SEGUNDA COLUMNA: Inputs de Descripción y 'Gestiones' (DERECHA) --}}
                {{-- La columna usa col-md-6 (media columna) --}}
                {{-- ============================================================== --}}
                <div class="col-md-6">

                    {{-- CAMPO VACÍO O ESPACIADOR: Para alinear con el Select de Proceso (col-md-6) --}}
                    {{-- Aquí puedes poner otros campos si los tienes, o dejar un espacio para alinear verticalmente --}}
                    <div class="form-group row" style="visibility: hidden;">
                        {{-- Deja este div vacío o agrega un campo no relacionado para que el siguiente input quede a la altura de 'condicional_oportunidad' --}}
                        <label for="descripcion_oportunidad" class="col-md-4 col-form-label text-md-right">Descripción Oportunidad</label>
                        <div class="col-md-6">
                            <input id="descripcion_oportunidad" type="text"
                                class="form-control @error('descripcion_oportunidad') is-invalid @enderror"
                                name="descripcion_oportunidad" value="{{ old('descripcion_oportunidad') }}">
                            @error('descripcion_oportunidad')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <hr class="mt-2 mb-2"> {{-- Separador visual --}}


                    {{-- 2. INPUT Descripcion Oportunidad (Alineado con Condicional Oportunidad) --}}
                    <div class="form-group row">
                        <label for="descripcion_oportunidad" class="col-md-4 col-form-label text-md-right">Descripción Oportunidad</label>
                        <div class="col-md-6">
                            <input id="descripcion_oportunidad" type="text" {{ $puedeEditar ? '' : 'disabled' }}
                                class="form-control @error('descripcion_oportunidad') is-invalid @enderror"
                                name="descripcion_oportunidad" value="{{ old('descripcion_oportunidad', $mensual->descripcion_oportunidad) }}">
                            @error('descripcion_oportunidad')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- 3. INPUT Descripcion Completitud --}}
                    <div class="form-group row">
                        <label for="descripcion_completitud" class="col-md-4 col-form-label text-md-right">Descripción Completitud</label>
                        <div class="col-md-6">
                            <input id="descripcion_completitud" type="text" {{ $puedeEditar ? '' : 'disabled' }}
                                class="form-control @error('descripcion_completitud') is-invalid @enderror"
                                name="descripcion_completitud" value="{{ old('descripcion_completitud', $mensual->descripcion_completitud) }}">
                            @error('descripcion_completitud')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- 4. INPUT Descripcion Progreso --}}
                    <div class="form-group row">
                        <label for="descripcion_progreso" class="col-md-4 col-form-label text-md-right">Descripción Progreso</label>
                        <div class="col-md-6">
                            <input id="descripcion_progreso" type="text" {{ $puedeEditar ? '' : 'disabled' }}
                                class="form-control @error('descripcion_progreso') is-invalid @enderror"
                                name="descripcion_progreso" value="{{ old('descripcion_progreso', $mensual->descripcion_progreso) }}">
                            @error('descripcion_progreso')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- 5. INPUT Descripcion Riesgo --}}
                    <div class="form-group row">
                        <label for="descripcion_riesgo" class="col-md-4 col-form-label text-md-right">Descripción Riesgo</label>
                        <div class="col-md-6">
                            <input id="descripcion_riesgo" type="text" {{ $puedeEditar ? '' : 'disabled' }}
                                class="form-control @error('descripcion_riesgo') is-invalid @enderror"
                                name="descripcion_riesgo" value="{{ old('descripcion_riesgo', $mensual->descripcion_riesgo) }}">
                            @error('descripcion_riesgo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- 6. INPUT Gestiones (General, queda al final de la columna derecha) --}}
                    <div class="form-group row">
                        <label for="gestiones" class="col-md-4 col-form-label text-md-right">Gestiones</label>
                        <div class="col-md-6">
                            <textarea id="gestiones" {{ $puedeEditar ? '' : 'disabled' }}
                                class="form-control @error('gestiones') is-invalid @enderror"
                                name="gestiones" rows="5">{{ old('gestiones', $mensual->gestiones) }}</textarea>
                            @error('gestiones')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>

            </div>
            @if($puedeEditar)
            {{-- Botón de Guardar (Fuera de las columnas para ocupar todo el ancho si es necesario) --}}
            <div class="form-group row mb-0">
                {{-- 1. Quitamos el offset para que la columna empiece en la izquierda. --}}
                {{-- 2. Usamos col-md-12 para que ocupe el ancho completo si es necesario. --}}
                <div class="col-md-5">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Registro
                    </button>
                </div>
            </div>
            @endif
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
