@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Dashboard')
@section('content_header_title', 'Dashboard')
@section('content_header_subtitle', 'Bienvenido al Sistema de Gestión de Indicadores' )

{{-- Extend the browser title --}}

{{-- Content body: main page content --}}

@section('content_body')
    <x-adminlte-card class="shadow mb-20" theme="primary">
        Bienvenido
        <x-adminlte-profile-widget
            name="{{ $usuario->nombre.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido }}"
            desc="{{ $usuario->roles->pluck('name')->implode(', ') }}"
            theme="primary"
            img="{{ Avatar::create($usuario->nombre.' '.$usuario->primer_apellido.' '.$usuario->segundo_apellido)
            ->toBase64() }}"
            >
        </x-adminlte-profile-widget>
    </x-adminlte-card>

    <x-adminlte-card class="shadow" theme="secondary" collapsible maximizable>
        <div class="row">
            @if (isset($iframe) && $iframe->is_active)
                <div class="col">
                    <div class="d-flex justify-content-center">
                        <iframe style="border: 0;"
                            src="{{ $iframe->url }}"
                            width="{{ $iframe->width }}"
                            height="{{ $iframe->height }}"
                            title="">
                        </iframe>
                    </div>
                </div>
            @else
            <div class="col">
                <div class="md-4">
                    <x-adminlte-info-box title="Título" text="algún texto" icon="far fa-lg fa-star"/>
                </div>
                <div class="md-4">
                    <x-adminlte-info-box title="Vistas" text="424" icon="fas fa-lg fa-eye text-dark" theme="gradient-teal"/>
                </div>
                <div class="md-4">
                    <x-adminlte-info-box title="Descargas" text="1205" icon="fas fa-lg fa-download" icon-theme="purple"/>
                </div>
            </div>
            <div class="col">
                <div class="md-4">
                    <x-adminlte-info-box title="528" text="Registros de usuarios" icon="fas fa-lg fa-user-plus text-primary" theme="gradient-primary" icon-theme="white"/>
                </div>
                <div class="md-4">
                    <x-adminlte-info-box title="Tareas" text="75/100" icon="fas fa-lg fa-tasks text-orange" theme="warning" icon-theme="dark" progress=75 progress-theme="dark" description="75% de las tareas se han completado"/>
                </div>
                <div class="md-4">
                    <x-adminlte-info-box title="Reputación" text="0/1000" icon="fas fa-lg fa-medal text-dark" theme="danger" id="ibUpdatable" progress=0 progress-theme="teal" description="0% reputación completada para alcanzar el siguiente nivel"/>
                </div>
            </div>
            @endif
        </div>
    </x-adminlte-card>

    <x-adminlte-card class="shadow" theme="secondary" icon="fas fa-lg fa-info-circle" maximizable collapsible>
        {{-- @can('dashboard.info') --}}
        <x-slot name="toolsSlot">
            <h3 class="card-title">
                <i class="fas fa-lg fa-info-circle"></i>
                Información del Sistema
            </h3>
        </x-slot>
        <div class="row">
            <div class="col-md-6">
                <a href="#;"  class="btn btn-primary">
                    btn-primary
                </a>
                <a href="#;"  class="btn btn-coral">
                    btn-coral
                </a>
                <a href="#;"  class="btn btn-orange">
                    btn-orange
                </a>
                <a href="#;"  class="btn btn-navy">
                    btn-navy
                </a>
                <a href="#;"  class="btn btn-sky-blue">
                    btn-sky-blue
                </a>
                <a href="#;"  class="btn btn-golden">
                    btn-golden
                </a>
                <a href="#;"  class="btn btn-forest">
                    btn-forest
                </a>
            </div>
            <div class="col-md-6">
                <a href="#;"  class="btn btn-outline-coral">
                    btn-outline-coral
                </a>
                <a href="#;"  class="btn btn-outline-orange">
                    btn-outline-orange
                </a>
                <a href="#;"  class="btn btn-outline-navy">
                    btn-outline-navy
                </a>
                <a href="#;"  class="btn btn-outline-sky-blue">
                    btn-outline-sky-blue
                </a>
                <a href="#;"  class="btn btn-outline-golden">
                    btn-outline-golden
                </a>
                <a href="#;"  class="btn btn-outline-forest">
                    btn-outline-forest
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6"></div>
        </div>
    </x-adminlte-card>
@stop

{{-- Push extra CSS --}}

@push('css')

@endpush

{{-- Push extra scripts --}}


@push('js')
    <script>
        $(document).ready(function() {
            let iBox = new _AdminLTE_InfoBox('ibUpdatable');
            let updateIBox = () => {
                // Update data.
                let rep = Math.floor(1000 * Math.random());
                let idx = rep < 100 ? 0 : (rep > 500 ? 2 : 1);
                let progress = Math.round(rep * 100 / 1000);
                let text = rep + '/1000';
                let icon = 'fas fa-lg fa-medal ' + ['text-primary', 'text-light', 'text-warning'][idx];
                let description = progress + '% reputación completada para alcanzar el siguiente nivel';
                let data = {text, icon, description, progress};
                iBox.update(data);
            };
            setInterval(updateIBox, 5000);
        })
    </script>
@endpush
