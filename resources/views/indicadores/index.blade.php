@extends('layouts.app')

@section('title', 'Indicadores')
@section('subtitle', 'Gestión de Indicadores')
@section('content_header_title', 'Indicadores')
@section('content_header_subtitle', 'Gestión de Indicadores')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content_body')
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

    <x-adminlte-card class="shadow" title="Indicadores" theme="primary" icon="fas fa-chart-line" collapsible maximizable>
        <x-slot name="toolsSlot">
            @can('indicadores.crear')
            <a href="{{ route('indicadores.index') }}" class="btn btn-secondary btn-xs" title="Crear Indicador">
                <i class="fas fa-fw fa-arrow-left"></i> Volver
            </a>
            @endcan
        </x-slot>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="btn-group">
                <a href="{{ route('indicadores.index', ['estado' => 'abierto']) }}"
                    class="btn btn-outline-primary {{ request('estado') == 'abierto' ? 'active' : '' }}">Abiertos</a>
                <a href="{{ route('indicadores.index', ['estado' => 'cerrado']) }}"
                    class="btn btn-outline-secondary {{ request('estado') == 'cerrado' ? 'active' : '' }}">Cerrados</a>
                <a href="{{ route('indicadores.index', ['estado' => 'completado']) }}"
                    class="btn btn-outline-success {{ request('estado') == 'completado' ? 'active' : '' }}">Completados</a>
            </div>
            @can('indicadores.crear')
            <a href="{{ route('indicadores.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Indicador
            </a>
            @endcan
        </div>
        @if($puedeVerEliminados)
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div>
                    <button class="btn btn-outline-warning btn-sm" type="button" data-toggle="collapse" data-target="#papeleraIndicadores" aria-expanded="false" aria-controls="papeleraIndicadores">
                        <i class="fas fa-trash"></i> Papelera
                        @if($countEliminados > 0)
                            <span class="badge badge-warning">{{ $countEliminados }}</span>
                        @endif
                    </button>
                </div>
            </div>
        @endif

        @php
            $heads = [
                'Nombre',
                'Tipo',
                'Asignado a',
                'Meta',
                'Estado',
                ['label' => 'Acciones', 'no-export' => true, 'width' => 5],
            ];

            $config['language'] = ['url' => 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/es-cl.json'];
            $config['order'] = [[0, 'asc']];
            $config['responsive'] = true;
            $config['fixHeader'] = true;
        @endphp
        <x-adminlte-datatable id="indicadores" :heads="$heads" :config="$config" bordered hoverable striped beatify with-buttons>
            @foreach ($indicadores as $indicador)
                <tr>
                    <td>{{ Str::limit($indicador->indicador, 60) }}</td>
                    <td>{{ $indicador->tipoIndicador->tipo_indicador ?? 'N/A' }}</td>
                    <td>{{ $indicador->usuario->nombreCompleto() ?? 'No asignado' }}</td>
                    <td>{{ number_format($indicador->meta, 2,',','.') }}%</td>
                    <td>
                        <span class="badge badge-{{ $indicador->estado == 'completado' ? 'success' : ($indicador->estado == 'cerrado' ? 'secondary' : 'primary') }}">
                            {{ ucfirst($indicador->estado) }}
                        </span>
                    </td>
                    <td class="text-nowrap">
                        <a href="{{ route('indicadores.show', $indicador) }}" class="btn btn-xs btn-info" title="Ver | Agregar Avance al indicador">
                            <i class="fas fa-eye"></i> Registro Mensual
                        </a>
                        @can('update', $indicador)
                        <a href="{{ route('indicadores.edit', $indicador) }}" class="btn btn-xs btn-warning" title="Editar Indicador y Proyección">
                            <i class="fas fa-edit"></i> editar
                        </a>
                        @endcan
                        @if(!$indicador->cerrado)
                            @can('delete', $indicador)
                        <form action="{{ route('indicadores.destroy', $indicador) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Está seguro de que desea eliminar este indicador?\nEsta acción no podrá revertirla');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger" title="Eliminar Indicador">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                        @endcan
                            @can('cerrar', $indicador)
                            <form action="{{ route('indicadores.cerrar', $indicador) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-xs btn-secondary" title="Cerrar">
                                    <i class="fas fa-lock"></i>
                                </button>
                            </form>
                            @endcan
                            @can('completar', $indicador)
                            <form action="{{ route('indicadores.completar', $indicador) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-xs btn-success" title="Completar">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            @endcan
                        @else
                            @can('reabrir', $indicador)
                            <form action="{{ route('indicadores.reabrir', $indicador) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary" title="Reabrir">
                                    <i class="fas fa-lock-open"></i>
                                </button>
                            </form>
                            @endcan
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </x-adminlte-card>
    @if($puedeVerEliminados)
    <div class="collapse" id="papeleraIndicadores">
        <x-adminlte-card class="shadow" title="Indicadores eliminados (SoftDeletes)" theme="warning" icon="fas fa-trash" collapsible maximizable>
            @php
                $headsDel = [
                    'Nombre',
                    'Tipo',
                    'Asignado a',
                    'Meta',
                    ['label' => 'Eliminado el', 'width' => 20],
                    ['label' => 'Acciones', 'no-export' => true, 'width' => 15],
                ];
                $configDel['language']  = ['url' => 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/es-cl.json'];
                $configDel['order']     = [[4, 'desc']];
                $configDel['responsive']= true;
            @endphp

            <x-adminlte-datatable id="indicadoresEliminados" :heads="$headsDel" :config="$configDel" bordered hoverable striped with-buttons>
                @forelse ($indicadoresEliminados as $el)
                    <tr>
                        <td>{{ Str::limit($el->indicador, 60) }}</td>
                        <td>{{ $el->tipoIndicador->tipo_indicador ?? 'N/A' }}</td>
                        <td>{{ optional($el->usuario)->nombreCompleto() ?? 'No asignado' }}</td>
                        <td>{{ number_format($el->meta, 2) }}</td>
                        <td>{{ optional($el->deleted_at)->format('d-m-Y H:i') }}</td>
                        <td class="text-nowrap">
                            <form action="{{ route('indicadores.restaurar', $el->cod_indicador) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('¿Restaurar este indicador?');">
                                @csrf
                                <button type="submit" class="btn btn-xs btn-success" title="Restaurar">
                                    <i class="fas fa-undo"></i> Restaurar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No hay indicadores eliminados.</td>
                    </tr>
                @endforelse
            </x-adminlte-datatable>
        </x-adminlte-card>
    </div>
    @endif

@endsection
