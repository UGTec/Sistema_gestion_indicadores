@extends('layouts.app')

@section('content_body')

    <h4 class="mb-4">
        Indicador #{{ $indicador->cod_indicador }}
    </h4>

    {{-- Datos básicos --}}
    <div class="card mb-4">
        <div class="card-header">
            <strong>Datos del Indicador</strong>
        </div>
        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $indicador->indicador }}</p>
            <p><strong>Objetivo:</strong> {{ $indicador->objetivo }}</p>
            <p><strong>Tipo:</strong> {{ $indicador->cod_tipo_indicador }}</p>
            <p><strong>Meta:</strong> {{ $indicador->meta }} %</p>
            <p><strong>Creado por:</strong> {{ $indicador->creador->nombre ?? 'N/D' }}</p>
        </div>
    </div>

    {{-- Reportes mensuales --}}
    <div class="card">
        <div class="card-header">
            <strong>Reportes Mensuales</strong>
            @can('reportes.informar')
            <a href=""
                class="btn btn-primary btn-sm float-right">
                Informar avance {{ now()->month }}/{{ now()->year }}
            </a>
            @endcan
        </div>
        <div class="card-body p-0">
            <table class="table table-sm table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Año</th>
                        <th>Mes</th>
                        <th>Numerador</th>
                        <th>Denominador</th>
                        <th>Resultado</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($indicador->reportes as $reporte)
                        <tr>
                            <td>{{ $reporte->año }}</td>
                            <td>{{ $reporte->mes }}</td>
                            <td>{{ $reporte->numerador }}</td>
                            <td>{{ $reporte->denominador }}</td>
                            <td>
                                @if(!is_null($reporte->resultado))
                                    {{ number_format($reporte->resultado,2) }} %
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <span class="badge
                                    @if($reporte->estado == 'aprobado') badge-success
                                    @elseif($reporte->estado == 'devuelto') badge-danger
                                    @else badge-secondary @endif">
                                    {{ ucfirst(str_replace('_',' ',$reporte->estado)) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('reportes.show', [$indicador->cod_indicador, $reporte->año, $reporte->mes]) }}"
                                   class="btn btn-sm btn-outline-info">
                                   Ver
                                </a>
                                @can('reportes.informar')
                                @if($reporte->estado == 'por_informar' || $reporte->estado == 'devuelto')
                                    <a href="{{ route('reportes.create', [$indicador->cod_indicador, $reporte->año, $reporte->mes]) }}"
                                       class="btn btn-sm btn-outline-primary">
                                       Editar
                                    </a>
                                @endif
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No existen reportes informados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('indicadores.index') }}" class="btn btn-secondary">Volver al listado</a>
    </div>

@stop
