@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', '')

{{-- Extend the browser title --}}

{{-- Content body: main page content --}}

@section('content_body')
    <x-adminlte-card class="shadow" theme="primary">
        Bienvenido
        <x-adminlte-profile-widget
            name="{{ $usuario->nombre.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido }}"
            desc="{{ $usuario->perfil->perfil }}"
            theme="primary"
            img="{{ Avatar::create($usuario->nombre.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido)
            ->toBase64() }}"
            >
        </x-adminlte-profile-widget>
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
