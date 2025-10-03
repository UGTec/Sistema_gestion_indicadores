@extends('layouts.app')

@section('title', 'Gestión de Paneles')
@section('subtitle', 'Lista de Paneles')
@section('content_header_title', 'Paneles')
@section('content_header_subtitle', 'Aquí puedes gestionar el acceso al panel Power BI en el sistema.')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content_body')
    {{-- Display success message if available --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
        </div>
    @endif
    @php
        $activeIframe = $iframes->firstWhere('is_active', true);
    @endphp
    @if($activeIframe)
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <strong>Panel Activo:</strong> {{ $activeIframe->name }}
            <a href="{{ route('iframe.display', $activeIframe->id) }}" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                <i class="fas fa-external-link-alt"></i> Ver
            </a>
        </div>
    @else
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            No hay ningún iframe activo actualmente.
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

    {{-- Card for managing iframes --}}
    <x-adminlte-card class="shadow" title="Gestión de Paneles" theme="primary" icon="fas fa-lg fa-iframe" collapsible maximizable>
        <x-slot name="toolsSlot">
            <a href="{{ route('iframes.create') }}" class="btn btn-success btn-xs" title="Crear Acceso">
                <i class="fas fa-plus"></i> Crear Acceso
            </a>
        </x-slot>
        @php
            $heads = [
                'ID',
                'Nombre',
                'URL',
                'Dimensiones',
                'Estado',
                'Creado',
                ['label' => 'Acciones', 'no-export' => true, 'width' => 5],
            ];
            $config['language'] = ['url' => 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/es-cl.json'];
            $config['order'] = [[0, 'desc']];
            $config['responsive'] = true;
            $config['fixHeader'] = true;
        @endphp

        <x-adminlte-datatable id="iframes" :heads="$heads" :config="$config" bordered hoverable striped beatify with-buttons>
            @forelse($iframes as $iframe)
            <tr>
                <td>{{ $iframe->id }}</td>
                <td>{{ $iframe->name }}</td>
                <td>
                    <span class="text-truncate" style="max-width: 200px; display: inline-block;">
                        {{ $iframe->url }}
                    </span>
                </td>
                <td>{{ $iframe->width }} × {{ $iframe->height }}</td>
                <td>
                    @if($iframe->is_active)
                    <span class="badge bg-success">
                        <i class="fas fa-check-circle"></i> Activo
                    </span>
                    @else
                    <span class="badge bg-secondary">Inactivo</span>
                    @endif
                </td>
                <td>{{ $iframe->created_at->format('d/m/Y') }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ route('iframes.show', $iframe) }}"
                            class="btn btn-xs btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('iframes.edit', $iframe) }}"
                            class="btn btn-xs btn-golden">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('iframes.destroy', $iframe) }}"
                            method="POST"
                            style="display: inline;"
                            onsubmit="return confirm('¿Estás seguro?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-coral">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @if($iframe->is_active)
                        <a href="{{ route('iframe.display', $iframe) }}"
                            class="btn btn-xs btn-success"
                            target="_blank">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No hay iframes registrados</td>
            </tr>
            @endforelse
        </x-adminlte-datatable>
    </x-adminlte-card>
@stop
