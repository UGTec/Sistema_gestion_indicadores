@extends('layouts.app')

@section('title', 'Detalles del Indicador')
@section('subtitle', 'Visualización de los detalles del indicador')
@section('content_header_title', 'Detalles del Indicador')
@section('content_header_subtitle', 'Visualización de los detalles del indicador')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content_body')
    {{-- Display success message if available --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    {{-- Display error messages if any --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <x-adminlte-card title="Detalles del Indicador" theme="primary" icon="fas fa-info-circle" collapsible maximizable>
        <x-slot name="toolsSlot">
            @can('update', $indicador)
                <a href="{{ route('indicadores.edit', $indicador) }}" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i> Editar
                </a>
            @endcan
            <div class="btn-group">
                @if(!$indicador->cerrado)
                    @can('indicadores.cerrar')
                    <form action="{{ route('indicadores.cerrar', $indicador) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-secondary">
                            <i class="fas fa-lock"></i> Cerrar
                        </button>
                    </form>
                    @endcan

                    @can('indicadores.completar')
                    <form action="{{ route('indicadores.completar', $indicador) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fas fa-check"></i> Completar
                        </button>
                    </form>
                    @endcan
                @else
                    {{-- @can('reabrir', $indicador) --}}
                    <form action="{{ route('indicadores.reabrir', $indicador) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-lock-open"></i> Reabrir
                        </button>
                    </form>
                    {{-- @endcan --}}
                @endif
            </div>
        </x-slot>
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Información Básica</h5>
                <hr>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label">Nombre:</label>
                    <div class="col-md-8">
                        <p class="">{{ $indicador->indicador }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label">Objetivo:</label>
                    <div class="col-md-8">
                        <p class="">{{ $indicador->objetivo }}</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label">Tipo:</label>
                    <div class="col-md-8">
                        <p class="">
                            {{ $indicador->tipoIndicador->tipo_indicador }} - {{ $indicador->tipoIndicador->descripcion }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <h5>Asignación y Estado</h5>
                <hr>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label">Meta:</label>
                    <div class="col-md-8">
                        <p class="">{{ number_format($indicador->meta, 2) }}%</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label">Asignado a:</label>
                    <div class="col-md-8">
                        <p class="">
                            {{ $indicador->usuario->nombre }} ({{ $indicador->usuarioAsignado->departamento->departamento ?? 'N/A' }})
                        </p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label">Estado:</label>
                    <div class="col-md-8">
                        <span class="badge badge-{{ $indicador->estado == 'completado' ? 'success' : ($indicador->estado == 'cerrado' ? 'secondary' : 'primary') }}">
                            {{ ucfirst($indicador->estado) }}
                        </span>
                        @if($indicador->cerrado)
                        <p class=" text-muted">
                            Cerrado el: {{ $indicador->fecha_cierre->format('d/m/Y H:i') }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h5>Archivos Adjuntos</h5>
                <hr>
                @if($indicador->relationLoaded('archivos') && $indicador->archivos->count() > 0)
                <div class="list-group">
                    @foreach($indicador->archivos as $archivo)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ route('archivos.download', $archivo) }}" target="_blank" class="flex-grow-1">
                            <i class="fas fa-file mr-2"></i>{{ $archivo->nombre_original }}
                            <small class="text-muted ml-2">({{ $archivo->tamanho_formateado }})</small>
                        </a>
                        {{-- @can('delete', $archivo) --}}
                        <form action="{{ route('archivos.destroy', $archivo) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('¿Está seguro que desea eliminar este archivo?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        {{-- @endcan --}}
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-muted">No hay archivos adjuntos</p>
                @endif
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <h5>Registro Mensual</h5>
                @can('create', [App\Models\IndicadorMensual::class, $indicador])
                <a href="{{ route('indicadores-mensuales.create', $indicador) }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Agregar Registro Mensual
                </a>
                @endcan
                <hr>
                @if($indicador->relationLoaded('indicadoresMensuales') && $indicador->indicadoresMensuales->count() > 0)
                @php
                    $heads = [
                        'Mes/Año',
                        'Numerador',
                        'Denominador',
                        'Resultado',
                        'Actualizado por',
                        'Fecha',
                        ['label' => 'Acciones', 'no-export' => true, 'width' => 10],
                    ];
                    $config = [
                        'language' => ['url' => 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/es-cl.json'],
                        'order' => [[0, 'desc']],
                        'responsive' => true,
                        'fixHeader' => true,
                    ];
                @endphp
                <x-adminlte-datatable id="indicadoresMensuales" :heads="$heads" :config="$config" bordered hoverable striped with-buttons>
                    @foreach($indicador->indicadoresMensuales->sortByDesc('año')->sortByDesc('mes') as $mensual)
                    <tr>
                        <td>{{ $mensual->mes }}/{{ $mensual->año }}</td>
                        <td>{{ number_format($mensual->numerador, 2) }}</td>
                        <td>{{ number_format($mensual->denominador, 2) }}</td>
                        <td>{{ number_format($mensual->resultado, 2) }}%</td>
                        <td>{{ $mensual->usuario->nombre ?? 'N/A' }}</td>
                        <td>{{ optional($mensual->fecha_actualizacion)->format('d-m-y') }} </td>
                        <td>
                            @can('update', $mensual)
                            <a href="{{ route('indicadores-mensuales.edit', [$indicador, $mensual]) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </x-adminlte-datatable>

                @else
                <p class="text-muted">No hay registros mensuales</p>
                @endif
            </div>
        </div>
        <a href="{{ route('indicadores.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </x-adminlte-card>
@stop
