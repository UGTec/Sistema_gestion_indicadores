@extends('layouts.app')

@section('title', 'Detalles del Tipo de Indicador')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Detalles del Tipo: {{ $tipo->tipo_indicador }}</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Código:</strong> {{ $tipo->cod_tipo_indicador }}
                    </li>
                    <li class="list-group-item">
                        <strong>Tipo:</strong> {{ $tipo->tipo_indicador }}
                    </li>
                    <li class="list-group-item">
                        <strong>Descripción:</strong> {{ $tipo->descripcion }}
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Indicadores Asociados ({{ $tipo->indicadores->count() }})</h6>
                    </div>
                    <div class="card-body">
                        @if($tipo->indicadores->count() > 0)
                            <ul class="list-group">
                                @foreach($tipo->indicadores as $indicador)
                                <li class="list-group-item">
                                    <a href="{{ route('indicadores.show', $indicador->cod_indicador) }}">
                                        {{ $indicador->cod_indicador }} - {{ Str::limit($indicador->indicador, 50) }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="alert alert-info">No hay indicadores asociados a este tipo</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('tipos_indicador.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
</div>
@endsection
