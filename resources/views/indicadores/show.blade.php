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
                    @if($indicador->estado == 'completado')
                        @can('indicadores.cerrar')
                        <form action="{{ route('indicadores.cerrar', $indicador) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-secondary">
                                <i class="fas fa-lock"></i> Cerrar
                            </button>
                        </form>
                        @endcan
                    @else
                        @can('indicadores.completar')
                        <form action="{{ route('indicadores.completar', $indicador) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fas fa-check"></i> Completar
                            </button>
                        </form>
                        @endcan
                    @endif
                @else
                    @can('indicadores.reabrir', $indicador)
                    <form action="{{ route('indicadores.reabrir', $indicador) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-lock-open"></i> Reabrir
                        </button>
                    </form>
                    @endcan
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

                <div class="form-group row">
                    <label class="col-md-4 col-form-label">Numerador:</label>
                    <div class="col-md-8">
                        <p class="">
                            {{ $indicador->parametro1}}
                        </p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label">Denominador:</label>
                    <div class="col-md-8">
                        <p class="">
                            {{ $indicador->parametro2}}
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
                        <p class="">{{ number_format($indicador->meta, 2,',','.') }}%</p>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label">Asignado a:</label>
                    <div class="col-md-8">
                        <p class="">
                            {{ $indicador->usuario->nombreCompleto() }} ({{ $indicador->usuarioAsignado->departamento->departamento ?? 'N/A' }})
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
                <h5>Valor proyectado y actual</h5>
                <hr>
                @php
                    $totalProy = (float) ($indicador->total_proyeccion ?? 0);
                    $totalReal = (float) ($indicador->total_real ?? 0);
                    $gap       = $totalProy - $totalReal;
                @endphp
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="p-2 border rounded">
                            <div class="small text-muted">Proyectado {{ $anio }}</div>
                            <div class="h4 mb-0">{{ number_format($totalProy, 2,',','.') }}</div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-2 mt-md-0">
                        <div class="p-2 border rounded">
                            <div class="small text-muted">Actual {{ $anio }}</div>
                            <div class="h4 mb-0">{{ number_format($totalReal, 2,',','.') }}</div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-2 mt-md-0">
                        <div class="p-2 border rounded">
                            <div class="small text-muted">Brecha (Proy - Actual)</div>
                            <div class="h4 mb-0 {{ $gap < 0 ? 'text-danger' : 'text-success' }}">
                                {{ number_format($gap, 2,',','.') }}
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Tabla de proyecciones del año seleccionado --}}
                <div class="card mt-4">
                    <div class="card-header">Proyección {{ $anio }}</div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 20%">Mes</th>
                                        <th style="width: 20%">Valor (%)</th>
                                        <th>Última actualización</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $monthNames = [
                                            1 => 'Enero',
                                            'Febrero',
                                            'Marzo',
                                            'Abril',
                                            'Mayo',
                                            'Junio',
                                            'Julio',
                                            'Agosto',
                                            'Septiembre',
                                            'Octubre',
                                            'Noviembre',
                                            'Diciembre'
                                        ];
                                    @endphp
                                    @forelse($indicador->proyecciones as $p)
                                    <tr>
                                        <td>{{ $monthNames[$p->mes] ?? $p->mes }}</td>
                                        <td>{{ number_format($p->valor, 2,',','.') }}</td>
                                        <td>{{ optional($p->updated_at)->format('d-m-Y H:i') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Sin proyecciones para {{ $anio }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <h5>Archivos Adjuntos</h5>
                <hr>
                @if($indicador->relationLoaded('archivos') && $indicador->archivos->count() > 0)
                <div class="list-group">
                    @foreach($indicador->archivos as $archivo)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ route('archivos.download', $archivo) }}" target="_blank" class="flex-grow-1" title="Descargar">
                            <i class="fas fa-file mr-2"></i>{{ $archivo->nombre_original }}
                            <small class="text-muted ml-2">({{ $archivo->tamanho_formateado }})</small>
                        </a>
                        @can('archivos.eliminar')
                        <form action="{{ route('archivos.destroy', $archivo) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('¿Está seguro que desea eliminar este archivo?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endcan
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
                @if($indicador->estado == 'abierto')
                    @can('indicadores_mensuales.crear', [App\Models\IndicadorMensual::class, $indicador])
                    <a href="{{ route('indicadores-mensuales.create', $indicador) }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Agregar Registro Mensual
                    </a>
                    @endcan
                @endif
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
                        'Archivos',
                    ];

                    if ($indicador->estado == 'abierto') {
                        $heads[] = ['label' => 'Acciones', 'no-export' => true, 'width' => 10];
                    }
                    $config = [
                        'language' => ['url' => 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/es-cl.json'],
                        'order' => [[0, 'asc']],
                        'responsive' => true,
                        'fixHeader' => true,
                    ];
                @endphp
                <x-adminlte-datatable id="indicadoresMensuales" :heads="$heads" :config="$config" bordered hoverable striped with-buttons>
                    @foreach($indicador->indicadoresMensuales->sortByDesc('año')->sortByDesc('mes') as $mensual)
                    <tr>
                        <td>{{ $mensual->mes }}/{{ $mensual->año }}</td>
                        <td>{{ number_format($mensual->numerador, 2,',','.') }}</td>
                        <td>{{ number_format($mensual->denominador, 2,',','.') }}</td>
                        <td>{{ number_format($mensual->resultado, 2,',','.') }}%</td>
                        <td>{{ $mensual->usuario->nombreCompleto() ?? 'N/A' }}</td>
                        <td>{{ optional($mensual->fecha_actualizacion)->format('d-m-y') }} </td>
                        <td>
                            @if ($mensual->archivos->isNotEmpty())
                                <ul>
                                    @foreach ($mensual->archivos as $archivo)
                                        <li>
                                            <a href="{{ route('archivos.download', $archivo->id) }}" target="_blank">
                                                {{ $archivo->nombre_original }}
                                            </a>
                                            ({{ round($archivo->tamanho / 1024 / 1024, 2) }} MB)
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <span>(Sin archivos adjuntos)</span>
                            @endif
                        </td>
                        @if($indicador->estado == 'abierto')
                        <td>
                            @can('update', $mensual)
                            <a href="{{ route('indicadores-mensuales.edit', [$indicador, $mensual]) }}" class="btn btn-sm btn-warning"
                            data-toggle="tooltip" title="Editar indicador mensual">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan
                            @if( auth()->user()->hasRole('Control de Gestión'))
                                @can('revisar', $mensual)
                                <a href="{{ route('indicadores-mensuales.revisar', [$indicador, $mensual]) }}" class="btn btn-sm btn-primary"
                                data-toggle="tooltip" title="Revisión Mensual">
                                    <i class="fas fa-check"></i>
                                </a>
                                @endcan
                            @endif
                            @if(!$mensual->cod_proceso_estrategico == null && auth()->user()->cod_usuario == $mensual->cod_usuario)
                            <a href="{{ route('indicadores-mensuales.revisar', [$indicador, $mensual]) }}" class="btn btn-sm btn-secondary"
                            data-toggle="tooltip" title="Ver Revisión Mensual">
                                <i class="fas fa-eye"></i>
                            </a>
                            @endif
                            @can('delete', $mensual)
                            <form action="{{ route('indicadores-mensuales.destroy', [$indicador, $mensual]) }}" method="POST" class="d-inline"
                            data-toggle="tooltip" title="Eliminar indicador mensual">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Está seguro que desea eliminar este registro mensual?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endcan
                        </td>
                        @endif
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
