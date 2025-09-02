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
            $config['order'] = [[0, 'desc']];
            $config['responsive'] = true;
            $config['fixHeader'] = true;
        @endphp
        <x-adminlte-datatable id="indicadores" :heads="$heads" :config="$config" bordered hoverable striped beatify with-buttons>
            @foreach ($indicadores as $indicador)
                <tr>
                    <td>{{ Str::limit($indicador->indicador, 50) }}</td>
                    <td>{{ $indicador->tipoIndicador->tipo_indicador ?? 'N/A' }}</td>
                    <td>{{ $indicador->usuario->nombreCompleto() ?? 'No asignado' }}</td>
                    <td>{{ number_format($indicador->meta, 2) }}</td>
                    <td>
                        <span class="badge badge-{{ $indicador->estado == 'completado' ? 'success' : ($indicador->estado == 'cerrado' ? 'secondary' : 'primary') }}">
                            {{ ucfirst($indicador->estado) }}
                        </span>
                    </td>
                    <td class="text-nowrap">
                        <a href="{{ route('indicadores.show', $indicador) }}" class="btn btn-xs btn-info" title="Ver">
                            <i class="fas fa-eye"></i>
                        </a>
                        @can('update', $indicador)
                        <a href="{{ route('indicadores.edit', $indicador) }}" class="btn btn-xs btn-warning" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @if(!$indicador->cerrado)
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
@endsection
