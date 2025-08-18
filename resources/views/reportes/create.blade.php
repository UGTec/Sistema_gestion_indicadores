@extends('layouts.app')
@section('content_body')
    <div class="container">
        <h5>Informar avance – Indicador {{ $indicador->cod_indicador }} / {{ $reporte->año }}-{{ $reporte->mes }}</h5>
        <form method="post" action="{{ route('reportes.store', [$indicador->cod_indicador,$reporte->año,$reporte->mes]) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label>Numerador</label>
                    <input type="number" step="1" name="numerador" class="form-control" value="{{ old('numerador', $reporte->numerador) }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label>Denominador</label>
                    <input type="number" step="1" name="denominador" class="form-control" value="{{ old('denominador', $reporte->denominador) }}" required>
                </div>
                <div class="form-group col-md-4">
                    <label>Observaciones</label>
                    <input type="text" name="observaciones" class="form-control" value="{{ old('observaciones', $reporte->observaciones) }}">
                </div>
            </div>
            <div class="form-group">
                <label>Adjuntos (PDF, Word, Excel, Imágenes, máx 10MB c/u)</label>
                <input type="file" name="adjuntos[]" class="form-control" multiple>
            </div>
            <button class="btn btn-primary">Guardar</button>
            @can('reportes.informar')
            <button formaction="{{ route('reportes.enviarRevisor', [$indicador->cod_indicador,$reporte->año,$reporte->mes]) }}" formmethod="post" class="btn btn-success ml-2">Enviar a Revisor</button>
            @endcan
        </form>
    </div>
@stop
