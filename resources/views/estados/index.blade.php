@extends('layouts.app')

@section('title', 'Estados de Usuario')
@section('subtitle', 'Estados')
@section('content_header_title', 'Estados de Usuario')
@section('content_header_subtitle', 'Gestión de Estados')
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
    {{-- Themes --}}
    <x-adminlte-card class="shadow" title="Estados de Usuario" theme="primary" icon="fas fa-lg fa-list" collapsible maximizable>
        {{-- Button to create new state --}}
        <x-slot name="toolsSlot">
            <a href="{{ route('estados.create') }}" class="btn btn-success" title="Nuevo Estado">
                <i class="fas fa-plus"></i> Nuevo Estado
            </a>
        </x-slot>
        {{-- Setup data for datatables --}}
        @php
            $heads = [
                'Código',
                'Estado',
                'Usuarios Asociados',
                ['label' => 'Acciones', 'no-export' => true, 'width' => 5],
            ];

            $config['language'] = ['url' => 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/es-cl.json'];
            $config['order'] = [[0, 'desc']];
            $config['responsive'] = true;
            $config['fixHeader'] = true;
        @endphp
        <hr>
        <x-adminlte-datatable id="estados" :heads="$heads" :config="$config" bordered hoverable striped beatify with-buttons>
            @foreach ($estados as $estado)
                <tr>
                    <td>{{ $estado->cod_estado_usuario }}</td>
                    <td>
                        <span class="badge badge-{{ $estado->cod_estado_usuario == 1 ? 'success' : 'danger' }}">
                            {{ $estado->estado_usuario }}
                        </span>
                    </td>
                    <td>{{ $estado->usuarios->count() }}</td>
                    <td class="text-center">
                        <a href="{{ route('estados.show', $estado->cod_estado_usuario) }}"
                            class="btn btn-xs btn-secondary"
                            title="Ver Detalles">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('estados.edit', $estado->cod_estado_usuario) }}"
                            class="btn btn-xs btn-success"
                            title="Editar Estado">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('estados.destroy', $estado->cod_estado_usuario) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Estás seguro de eliminar este estado?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </x-adminlte-card>
@stop
