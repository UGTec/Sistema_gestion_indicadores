@extends('layouts.app')

@section('subtitle', 'Editar Usuario')
@section('content_header_title', 'Editar Usuario')
@section('content_header_subtitle', 'Modificar los detalles del usuario')
@section('plugins.Select2', true)
@section('plugins.BootstrapSwitch', true)

@section('content_body')
    <x-adminlte-card theme="dark" theme-mode="outline" class="shadow elevation-3" title="Editar Usuario: {{ $usuario->nombre }}" icon="fas fa-lg fa-user-edit">
        <form action="{{ route('usuarios.update', $usuario->cod_usuario) }}" method="POST">
            @csrf
            @method('PUT')

            @include('usuarios.form', [
                'usuario' => $usuario,
                'departamentos' => $departamentos,
                'estados' => $estados
            ])

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </x-adminlte-card>
@stop
