@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', '')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

{{-- Extend the browser title --}}

{{-- Content body: main page content --}}

@section('content_body')
    {{-- Themes --}}
    <x-adminlte-card class="shadow" title="Dark Card" theme="primary" icon="fas fa-lg fa-moon" collapsible maximizable>
        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quod adipisci non earum et delectus mollitia voluptates ullam inventore consectetur itaque repudiandae rem doloribus, architecto voluptas voluptatum, ipsum temporibus quam at!

        {{-- Setup data for datatables --}}
        @php
            $heads = [
                'ID',
                'Name',
                ['label' => 'Phone', 'width' => 40],
                ['label' => 'Actions', 'no-export' => true, 'width' => 5],
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
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </x-adminlte-datatable>

    </x-adminlte-card>
@stop

{{-- Push extra CSS --}}

@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
    {{-- <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script> --}}
@endpush
