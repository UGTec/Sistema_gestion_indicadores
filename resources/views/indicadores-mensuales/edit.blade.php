@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('indicadores.show', $indicador) }}" class="btn btn-sm btn-secondary float-right">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <h5 class="mb-0">Editar Registro Mensual:
                        {{ ucfirst(\Carbon\Carbon::create(null, $mensual->mes)->locale('es')->monthName) }} {{ $mensual->año }}
                    </h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('indicadores-mensuales.update', [$indicador, $mensual]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Mes/Año</label>
                            <div class="col-md-6">
                                <p class="form-control-plaintext">
                                    {{ ucfirst(\Carbon\Carbon::create(null, $mensual->mes)->locale('es')->monthName) }} {{ $mensual->año }}
                                </p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="numerador" class="col-md-4 col-form-label text-md-right">Numerador</label>
                            <div class="col-md-6">
                                <input id="numerador" type="number" step="0.01" class="form-control @error('numerador') is-invalid @enderror"
                                    name="numerador" value="{{ old('numerador', $mensual->numerador) }}" required>
                                @error('numerador')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="denominador" class="col-md-4 col-form-label text-md-right">Denominador</label>
                            <div class="col-md-6">
                                <input id="denominador" type="number" step="0.01" class="form-control @error('denominador') is-invalid @enderror"
                                    name="denominador" value="{{ old('denominador', $mensual->denominador) }}" required>
                                @error('denominador')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="observaciones" class="col-md-4 col-form-label text-md-right">Observaciones</label>
                            <div class="col-md-6">
                                <textarea id="observaciones" class="form-control @error('observaciones') is-invalid @enderror"
                                    name="observaciones" rows="3">{{ old('observaciones', $mensual->observaciones) }}</textarea>
                                @error('observaciones')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Archivos Actuales</label>
                            <div class="col-md-6">
                                @if($mensual->archivos->count() > 0)
                                <div class="list-group">
                                    @foreach($mensual->archivos as $archivo)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="{{ route('archivos.download', $archivo) }}" target="_blank">
                                            <i class="fas fa-file mr-2"></i>{{ $archivo->nombre_original }}
                                        </a>
                                        @can('archivos.eliminar')
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirmarEliminarArchivo({{ $archivo->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endcan
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <p class="text-muted">No hay archivos adjuntos</p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="archivos" class="col-md-4 col-form-label text-md-right">Nuevos Archivos</label>
                            <div class="col-md-6">
                                <input type="file" id="archivos" class="form-control-file @error('archivos') is-invalid @enderror"
                                    name="archivos[]" multiple>
                                <small class="form-text text-muted">
                                    Puede seleccionar múltiples archivos (Máximo 10MB en total)
                                </small>
                                @error('archivos')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('archivos.*')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Actualizar Registro
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="delete-file-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('js')
    <script>
        function confirmarEliminarArchivo(archivoId) {
            if (confirm('¿Está seguro que desea eliminar este archivo?')) {
                const form = document.getElementById('delete-file-form');
                form.action = `/archivos/${archivoId}`;
                form.submit();
            }
        }
    </script>
@endpush
