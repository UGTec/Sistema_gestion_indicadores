@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Usuarios')
@section('content_header_title', 'Usuarios')
@section('content_header_subtitle', '')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

{{-- Extend the browser title --}}

@section('content_body')
    {{-- Themes --}}
    <x-adminlte-card class="shadow" title="Usuarios" theme="primary" icon="fas fa-lg fa-users" collapsible maximizable>
        {{-- Setup data for datatables --}}
        @php
            $heads = [
                'ID',
                'Nombre',
                ['label' => 'Teléfono', 'width' => 40],
                ['label' => 'Acciones', 'no-export' => true, 'width' => 5],
            ];

            $config['language'] = ['url' => 'https://cdn.datatables.net/plug-ins/1.11.3/i18n/es-cl.json'];
            $config['order'] = [[0, 'desc']];
            $config['responsive'] = true;
            $config['fixHeader'] = true;
        @endphp
        <hr>
        {{-- Minimal example / fill data using the component slot --}}
        <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" bordered hoverable striped beatify
        with-buttons>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->phone }}</td>
                    <td class="text-center">
                        {{-- <x-adminlte-button class="btn-xs" icon="fas fa-edit" data-toggle="modal"
                            data-target="#editModal{{ $user->id }}" title="Editar" />
                        <x-adminlte-button class="btn-xs" icon="fas fa-trash" data-toggle="modal"
                            data-target="#deleteModal{{ $user->id }}" title="Eliminar" /> --}}
                    </td>
                </tr>

                {{-- Edit Modal --}}
                {{-- @include('users.edit', ['user' => $user]) --}}

                {{-- Delete Modal --}}
                {{-- @include('users.delete', ['user' => $user]) --}}
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
