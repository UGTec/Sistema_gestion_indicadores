@extends('layouts.app')

@section('title', 'Listado de Departamentos')
@section('subtitle', 'Departamentos')
@section('content_header_title', 'Departamentos')
@section('content_header_subtitle', 'Gestión de Departamentos')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content_body')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    {{-- Card for Departments --}}
    <x-adminlte-card class="shadow" title="Departamentos" theme="primary" icon="fas fa-lg fa-building" collapsible maximizable>
        {{-- Button to create new department --}}
        @can('departamentos.crear')
            <x-slot name="toolsSlot">
                <a href="{{ route('departamentos.create') }}" class="btn btn-xs btn-success" title="Nuevo Departamento">
                    <i class="fas fa-plus"></i> Nuevo Departamento
                </a>
            </x-slot>
        @endcan
        {{-- Setup data for datatables --}}
        @php
            $heads = [
                'Código',
                'Departamento',
                'División',
                'Usuarios',
                ['label' => 'Acciones', 'no-export' => true, 'width' => 5],
            ];

            $config['language'] = ['url' => 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/es-cl.json'];
            $config['order'] = [[0, 'desc']];
            $config['responsive'] = true;
            $config['fixHeader'] = true;
        @endphp
        <hr>
        <x-adminlte-datatable id="departamentos" :heads="$heads" :config="$config" bordered hoverable striped beatify with-buttons>
            @foreach ($departamentos as $departamento)
                <tr>
                    <td>{{ $departamento->cod_departamento }}</td>
                    <td>{{ $departamento->departamento }}</td>
                    <td>{{ $departamento->division->division ?? 'N/A' }}</td>
                    <td>{{ $departamento->usuarios->count() }}</td>
                    <td class="text-center">
                        @can('departamentos.ver')
                            <a href="{{ route('departamentos.show', $departamento->cod_departamento) }}"
                                class="btn btn-xs btn-secondary"
                                title="Ver Detalles">
                                <i class="fas fa-eye"></i>
                            </a>
                        @endcan
                        @can('departamentos.editar')
                            <a href="{{ route('departamentos.edit', $departamento->cod_departamento) }}"
                                class="btn btn-xs btn-success"
                                title="Editar Departamento">
                                <i class="fas fa-edit"></i>
                            </a>
                        @endcan
                        @can('departamentos.eliminar')
                            <form action="{{ route('departamentos.destroy', $departamento->cod_departamento) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Estás seguro de eliminar este departamento?')">
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
