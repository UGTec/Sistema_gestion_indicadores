@extends('layouts.app')

@section('title', 'Editar Registro Mensual')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Editar Registro Mensual - Indicador: {{ $indicador->cod_indicador }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('indicadores.registros.update', [$indicador->cod_indicador, $registro->cod_indicador, $registro->mes, $registro->año]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Mes</label>
                    <input type="text" class="form-control" value="{{ $meses[$registro->mes] }}" readonly>
                    <input type="hidden" name="mes" value="{{ $registro->mes }}">
                </div>
                <div class="form-group col-md-3">
                    <label>Año</label>
                    <input type="text" class="form-control" value="{{ $registro->año }}" readonly>
                    <input type="hidden" name="año" value="{{ $registro->año }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="cod_usuario">Responsable del Registro</label>
                    <select class="form-control" id="cod_usuario" name="cod_usuario" required>
                        <option value="">Seleccione un responsable</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->cod_usuario }}"
                                {{ $registro->cod_usuario == $usuario->cod_usuario ? 'selected' : '' }}>
                                {{ $usuario->nombre }} {{ $usuario->primer_apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="numerador">Numerador</label>
                    <input type="number" class="form-control" id="numerador" name="numerador"
                           value="{{ $registro->numerador }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="denominador">Denominador</label>
                    <input type="number" class="form-control" id="denominador" name="denominador"
                           value="{{ $registro->denominador }}" required>
                </div>
            </div>

            <div class="form-group">
                <label for="resultado">Resultado (%)</label>
                <input type="number" class="form-control" id="resultado" name="resultado"
                       value="{{ $registro->resultado }}" min="0" max="100" step="0.01">
                <small class="form-text text-muted">Puede editarlo manualmente si es necesario</small>
            </div>

            <div class="form-group">
                <label for="fecha_actualizacion">Fecha de Actualización</label>
                <input type="date" class="form-control" id="fecha_actualizacion" name="fecha_actualizacion"
                       value="{{ $registro->fecha_actualizacion ?? date('Y-m-d') }}">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar Registro
                </button>
                <a href="{{ route('indicadores.show', $indicador->cod_indicador) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
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
@endsection
