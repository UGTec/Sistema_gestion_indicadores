@extends('layouts.app')

@section('title', 'Indicadores')
@section('subtitle', 'Listado de Indicadores')
@section('content_header_title', 'Indicadores')
@section('content_header_subtitle', 'Listado de Indicadores')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content_body')
    {{-- Display success message if available --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    {{-- Display error messages if any --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <x-adminlte-card class="shadow" title="Listado de Indicadores" theme="primary" icon="fas fa-chart-line" collapsible maximizable>
        <x-slot name="toolsSlot">
            {{-- Button to create a new indicator --}}
            @can('indicadores.crear')
            <a href="{{ route('indicadores.create') }}" class="btn btn-xs btn-success">
                <i class="fas fa-plus"></i> Nuevo Indicador
            </a>
            @endcan
        </x-slot>
        {{-- Setup data for datatables --}}
        @php
            $heads = [
                'Código',
                'Indicador',
                'Tipo',
                'Responsable',
                ['label' => 'Acciones', 'no-export' => true, 'width' => 5],
            ];
            $config['language'] = ['url' => 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/es-cl.json'];
            $config['order'] = [[0, 'desc']];
            $config['responsive'] = true;
            $config['fixHeader'] = true;
        @endphp
        <hr>
        <x-adminlte-datatable id="indicadores" :heads="$heads" :config="$config" bordered hoverable striped beatify with-buttons>
            @foreach($indicadores as $indicador)
            <tr>
                <td>{{ $indicador->cod_indicador }}</td>
                <td>{{ Str::limit($indicador->indicador, 50) }}</td>
                <td>{{ $indicador->tipoIndicador->tipo_indicador ?? 'N/A' }}</td>
                <td>{{ $indicador->usuario->nombre ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('indicadores.show', $indicador->cod_indicador) }}" class="btn btn-xs btn-info">
                        <i class="fas fa-eye"></i>
                    </a>
                    @can('indicadores.editar')
                    <a href="{{ route('indicadores.edit', $indicador->cod_indicador) }}" class="btn btn-xs btn-primary">
                        <i class="fas fa-edit"></i>
                    </a>
                    @endcan
                    @can('indicadores.eliminar')
                    <form action="{{ route('indicadores.destroy', $indicador->cod_indicador) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Estás seguro de eliminar este indicador?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    @endcan
                </td>
            </tr>
            @endforeach
        </x-adminlte-datatable>
    </x-adminlte-card>
@stop
