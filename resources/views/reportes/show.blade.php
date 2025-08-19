@extends('layouts.app')
@section('content_body')
<div class="container">
    <h5>
        Reporte {{ $reporte->año }}-{{ $reporte->mes }} – Estado: <span class="badge badge-info">{{ $reporte->estado }}</span>
    </h5>
    <p><strong>Numerador:</strong> {{ $reporte->numerador }} | <strong>Denominador:</strong> {{ $reporte->denominador }} | <strong>Resultado:</strong> {{ $reporte->resultado }}%</p>

    <h6>Adjuntos</h6>
    <ul>
        @forelse($reporte->adjuntos as $a)
        <li>
            <a href="{{ route('adjuntos.descargar',$a->id) }}">{{ $a->nombre_original }}</a>
        </li>
        @empty
        <li>Sin adjuntos</li>
        @endforelse
    </ul>

    <h6>Bitácora</h6>
    <ul>
        @foreach($reporte->logs as $l)
        <li>{{ $l->created_at }} – {{ $l->accion }}: {{ $l->mensaje }}</li>
        @endforeach
    </ul>

    @role('revisor')
    <form method="post" action="{{ route('reportes.revisor', [$indicador->cod_indicador,$reporte->año,$reporte->mes]) }}" class="mt-3">
        @csrf
        <div class="form-group">
            <textarea name="mensaje" class="form-control" placeholder="Observaciones"></textarea>
        </div>
        <button name="accion" value="aprobar" class="btn btn-success">Aprobar → Control</button>
        <button name="accion" value="devolver" class="btn btn-warning">Devolver a Informante</button>
    </form>
    @endrole

    @role('control_gestion')
    <form method="post" action="{{ route('reportes.control', [$indicador->cod_indicador,$reporte->año,$reporte->mes]) }}" class="mt-3">
        @csrf
        <div class="form-group">
            <textarea name="mensaje" class="form-control" placeholder="Observaciones"></textarea>
        </div>
        <button name="accion" value="aprobar" class="btn btn-success">Aprobar → Jefatura</button>
        <button name="accion" value="devolver" class="btn btn-warning">Devolver a Informante</button>
    </form>
    @endrole

    @role('jefatura_division')
    <form method="post" action="{{ route('reportes.jefatura', [$indicador->cod_indicador,$reporte->año,$reporte->mes]) }}" class="mt-3">
        @csrf
        <div class="form-group">
            <textarea name="mensaje" class="form-control" placeholder="Observaciones"></textarea>
        </div>
        <button name="accion" value="aprobar" class="btn btn-success">Aprobar (Final)</button>
        <button name="accion" value="devolver" class="btn btn-warning">Devolver a Informante</button>
    </form>
    @endrole
</div>
@endsection
