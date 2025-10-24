@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'Permisos')
@section('subtitle', 'Lista de Permisos')
@section('content_header_title', 'Permisos')
@section('content_header_subtitle', 'Administración de permisos del sistema')
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
    @endif{{-- Themes --}}
    {{-- <div class="container-fluid"> --}}
        <x-adminlte-card class="shadow" title="Permisos" theme="primary" icon="fas fa-lg fa-lock" collapsible maximizable>
            <x-slot name="toolsSlot">
                @can('permisos.crear')
                <a href="{{ route('permisos.create') }}" class="btn btn-xs btn-success">
                    <i class="fas fa-plus"></i> Nuevos Permisos
                </a>
                @endcan
            </x-slot>
            @foreach($permissions as $module => $modulePermissions)
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">{{ ucfirst($module) }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($modulePermissions as $permission)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="card-title mb-0 text-truncate">{{ $permission->name }}</h6>
                                        <div class="d-flex">
                                            @can('permisos.editar')
                                            <a href="{{ route('permisos.edit', $permission->id) }}" class="btn btn-xs btn-primary mr-2">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('permisos.eliminar')
                                            <form action="{{ route('permisos.destroy', $permission->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Estás seguro de eliminar este permiso?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </x-adminlte-card>
    {{-- </div> --}}
@stop
