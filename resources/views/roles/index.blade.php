@extends('layouts.app')

@section('title', 'Gestión de Perfiles')
@section('subtitle', 'Perfiles y Permisos')
@section('content_header_title', 'Perfiles del Sistema')
@section('content_header_subtitle', 'Gestión de perfiles y permisos del sistema')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content_body')
    {{-- Display success or error messages --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    {{-- Setup data for datatables --}}
    <x-adminlte-card class="shadow" title="Perfiles" theme="primary" icon="fas fa-lg fa-users" collapsible maximizable>
        <x-slot name="toolsSlot">
            {{-- Add any additional tools here --}}
            @can('roles.crear')
            <a href="{{ route('roles.create') }}" class="btn btn-xs btn-success">
                <i class="fas fa-plus"></i> Nuevo Perfil
            </a>
            @endcan
        </x-slot>
        @php
            $heads = [
                'Nombre',
                'Permisos',
                ['label' => 'Acciones', 'no-export' => true, 'width' => 5],
            ];

            $config['language'] = ['url' => 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/es-cl.json'];
            $config['order'] = [[0, 'asc']];
            $config['responsive'] = true;
            $config['fixHeader'] = true;
        @endphp
        <hr>
        <x-adminlte-datatable id="roles" :heads="$heads" :config="$config" bordered hoverable striped beatify with-buttons>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>
                        @foreach($role->permissions as $permission)
                            <span class="badge badge-primary">{{ $permission->name }}</span>
                        @endforeach
                    </td>
                    <td class="text-center">
                        @can('roles.editar')
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-xs btn-success" title="Editar Rol">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('roles.eliminar')
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Estás seguro de eliminar este rol?')">
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
