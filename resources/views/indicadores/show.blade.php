@extends('layouts.app')

@section('title', 'Detalles del Indicador')
@section('subtitle', 'Detalles del Indicador')
@section('content_header_title', 'Detalles del Indicador')
@section('content_header_subtitle', 'Detalles del Indicador')

@section('content_body')
    <x-adminlte-card class="shadow" title="Detalles del Indicador {{ $indicador->cod_indicador }}" theme="primary" icon="fas fa-chart-line" collapsible maximizable>
        <x-slot name="toolsSlot">
            <a href="{{ route('indicadores.index') }}" class="btn btn-secondary btn-xs" title="Volver a Indicadores">
                <i class="fas fa-arrow-left"></i> Volver a Indicadores
            </a>
        </x-slot>
        <div class="row">
                <div class="col-md-6">
                    <h6>Información General</h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Indicador:</strong> {{ $indicador->indicador }}
                        </li>
                        <li class="list-group-item">
                            <strong>Objetivo:</strong> {{ $indicador->objetivo }}
                        </li>
                        <li class="list-group-item">
                            <strong>Tipo:</strong> {{ $indicador->tipoIndicador->tipo_indicador ?? 'N/A' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Responsable:</strong> {{ $indicador->usuario->nombre ?? 'N/A' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Meta:</strong> {{ $indicador->meta ?? 'N/A' }}
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Registros Mensuales</h6>
                        {{-- @can('indicadores.registros.create') --}}
                        <a href="{{ route('indicadores.registros.create', $indicador->cod_indicador) }}" class="btn btn-sm btn-success">
                            <i class="fas fa-plus"></i> Nuevo Registro
                        </a>
                        {{-- @endcan --}}
                    </div>

                    @if($registros->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Periodo</th>
                                    <th>Numerador</th>
                                    <th>Denominador</th>
                                    <th>Resultado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registros as $registro)
                                <tr>
                                    <td>{{ $registro->mes }}/{{ $registro->año }}</td>
                                    <td>{{ $registro->numerador }}</td>
                                    <td>{{ $registro->denominador }}</td>
                                    <td>{{ $registro->resultado }}%</td>
                                    <td>
                                        {{-- @can('indicadores.registros.edit') --}}
                                        <a href="{{ route('indicadores.registros.edit', [$indicador->cod_indicador, $registro->cod_indicador, $registro->mes, $registro->año]) }}" class="btn btn-xs btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        {{-- @endcan --}}
                                        {{-- @can('indicadores.registros.destroy') --}}
                                        <form action="{{ route('indicadores.registros.destroy', [$indicador->cod_indicador, $registro->cod_indicador, $registro->mes, $registro->año]) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Estás seguro de eliminar este registro?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        {{-- @endcan --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-info">No hay registros mensuales para este indicador</div>
                    @endif
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('indicadores.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
    </x-adminlte-card>
@stop
