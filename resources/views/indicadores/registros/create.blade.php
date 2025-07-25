@extends('layouts.app')

@section('title', 'Agregar Registro Mensual')
@section('subtitle', 'Formulario para agregar un nuevo registro mensual al indicador')
@section('content_header_title', 'Agregar Registro Mensual')
@section('content_header_subtitle', 'Complete el formulario para registrar un nuevo valor mensual del indicador.')

@section('plugins.TempusDominusBs4', true)

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

    <x-adminlte-card class="shadow" title="Agregar Registro Mensual - Indicador: {{ $indicador->cod_indicador }}" theme="primary" icon="fas fa-plus" collapsible maximizable>
        <x-slot name="toolsSlot">
            <a href="{{ route('indicadores.show', $indicador->cod_indicador) }}" class="btn btn-xs btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Indicador
            </a>
        </x-slot>
        <form action="{{ route('indicadores.registros.store', $indicador->cod_indicador) }}" method="POST">
            @csrf

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="mes">Mes</label>
                    <select class="form-control @error('mes') is-invalid @enderror" id="mes" name="mes">
                        <option value="">Seleccione un mes</option>
                        @foreach($meses as $key => $mes)
                            <option value="{{ $key }}">{{ $mes }}</option>
                        @endforeach
                    </select>
                    @error('mes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-3">
                    <label for="año">Año</label>
                    <input type="number" class="form-control @error('año') is-invalid @enderror" id="año" name="año"
                           min="2000" max="2100" value="{{ date('Y') }}">
                    @error('año')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="cod_usuario">Responsable del Registro</label>
                    <select class="form-control @error('cod_usuario') is-invalid @enderror" id="cod_usuario" name="cod_usuario">
                        <option value="">Seleccione un responsable</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->cod_usuario }}">{{ $usuario->nombre }} {{ $usuario->primer_apellido }}</option>
                        @endforeach
                    </select>
                    @error('cod_usuario')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="numerador">Numerador</label>
                    <input type="number" class="form-control @error('numerador') is-invalid @enderror" id="numerador" name="numerador">
                    @error('numerador')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="denominador">Denominador</label>
                    <input type="number" class="form-control @error('denominador') is-invalid @enderror" id="denominador" name="denominador">
                    @error('denominador')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="resultado">Resultado (%)</label>
                <input type="number" class="form-control @error('resultado') is-invalid @enderror" id="resultado" name="resultado"
                       min="0" max="100" step="0.01" readonly>
                @error('resultado')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Se calcula automáticamente</small>
            </div>

            <div class="form-group">
                <label for="fecha_actualizacion">Fecha de Actualización</label>
                <input type="date" class="form-control @error('fecha_actualizacion') is-invalid @enderror" id="fecha_actualizacion" name="fecha_actualizacion"
                       value="{{ date('Y-m-d') }}">
                @error('fecha_actualizacion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Registro
                </button>
                <a href="{{ route('indicadores.show', $indicador->cod_indicador) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </x-adminlte-card>
@stop

@push('js')
<script>
    $(document).ready(function() {
        // Calcular resultado automáticamente
        function calcularResultado() {
            const numerador = parseFloat($('#numerador').val()) || 0;
            const denominador = parseFloat($('#denominador').val()) || 0;

            if (denominador !== 0) {
                const resultado = (numerador / denominador) * 100;
                $('#resultado').val(resultado.toFixed(2));
            } else {
                $('#resultado').val(0);
            }
        }

        $('#numerador, #denominador').on('input', calcularResultado);
    });
</script>
@endpush
