@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'Gestión de Usuarios')
@section('subtitle', 'Usuarios')
@section('content_header_title', 'Usuarios')
@section('content_header_subtitle', 'Gestión de Usuarios')

{{-- Include necessary plugins --}}
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
    {{-- Themes --}}
    <x-adminlte-card class="shadow" title="Usuarios" theme="primary" icon="fas fa-lg fa-users" collapsible maximizable>
        @can('usuarios.crear')
        {{-- Tools slot for creating a new user --}}
        <x-slot name="toolsSlot">
            <a href="{{ route('usuarios.create') }}" class="btn btn-success btn-xs" title="Crear Usuario">
                <i class="fas fa-plus"></i> Crear Usuario
            </a>
        </x-slot>
        @endcan
        {{-- Setup data for datatables --}}
        @php
            $heads = [
                'ID',
                'Nombre',
                'Correo Electrónico',
                'Departamento',
                'Perfil',
                'Estado',
                ['label' => 'Acciones', 'no-export' => true, 'width' => 5],
            ];

            $config['language'] = ['url' => 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/es-cl.json'];
            $config['order'] = [[0, 'desc']];
            $config['responsive'] = true;
            $config['fixHeader'] = true;
        @endphp
        <hr>
        <x-adminlte-datatable id="usuarios" :heads="$heads" :config="$config" bordered hoverable striped beatify
        with-buttons>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->cod_usuario }}</td>
                    <td>{{ $usuario->nombre.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido }}</td>
                    <td>{{ $usuario->correo_electronico }}</td>
                    <td>{{ $usuario->departamento->departamento }}</td>
                    <td>
                        @foreach ($usuario->roles as $rol)
                            <span class="badge badge-info">{{ $rol->name }}</span>
                        @endforeach
                    </td>
                    <td class="text-center">
                        @if ($usuario->estado)
                            <span class="badge badge-{{ $usuario->estado->cod_estado_usuario == 1 ? 'success' : 'danger' }}">
                                {{ $usuario->estado->estado_usuario }}
                            </span>
                        @else
                            <span class="badge badge-secondary">Sin Estado</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @can('usuarios.ver')
                        <a href="{{ route('usuarios.show', $usuario->cod_usuario) }}"
                            class="btn btn-xs btn-secondary"
                            title="Ver Detalles">
                            <i class="fas fa-eye "></i>
                        </a>
                        @endcan
                        @can('usuarios.editar')
                        <a href="{{ route('usuarios.edit', $usuario->cod_usuario) }}"
                            class="btn btn-xs btn-success"
                            title="Editar Usuario">
                                <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('usuarios.eliminar')
                        <form action="{{ route('usuarios.destroy', $usuario->cod_usuario) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
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

@section('css')
    <style>
        /* Custom styles can be added here */
    </style>
@endsection

@section('js')
    <script>
        // Custom JavaScript can be added here
    </script>
@endsection
