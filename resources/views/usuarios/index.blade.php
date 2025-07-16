@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Usuarios')
@section('content_header_title', 'Usuarios')
@section('content_header_subtitle', '')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content_body')
    {{-- Themes --}}
    <x-adminlte-card class="shadow" title="Usuarios" theme="primary" icon="fas fa-lg fa-users" collapsible maximizable>
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
                    <td>{{ $usuario->perfil->perfil }}</td>
                    <td>{{ $usuario->estado->estado_usuario }}</td>
                    <td class="text-center">
                        <x-adminlte-button
                            theme="primary"
                            class="btn-xs"
                            icon="fas fa-edit"
                            title="Editar"
                            data-toggle="modal"
                            data-target="#modalPurple"
                        />
                        <x-adminlte-button theme="danger" class="btn-xs" icon="fas fa-trash" title="Eliminar" />
                    </td>
                </tr>

                {{-- Edit Modal --}}
                <x-adminlte-modal id="modalPurple" title="Editar Usuario" theme="purple"
                    icon="fas fa-bolt" size='lg' static-backdrop>
                    @include('usuarios.edit', ['usuario' => $usuario])
                </x-adminlte-modal>


                {{-- Delete Modal --}}
                {{-- @include('usuarios.delete', ['usuario' => $usuario]) --}}
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
