@extends('layouts.app')

@section('title', 'Editar Indicador')
@section('subtitle', 'Formulario para editar el indicador')
@section('content_header_title', 'Editar Indicador')
@section('content_header_subtitle', 'Formulario para editar el indicador')

@section('content_body')

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Editar Indicador: {{ $indicador->indicador }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('indicadores.update', $indicador) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="indicador" class="col-md-3 col-form-label text-md-right">Nombre del Indicador</label>
                            <div class="col-md-9">
                                <textarea id="indicador" class="form-control @error('indicador') is-invalid @enderror"
                                    name="indicador" required autofocus rows="3">{{ old('indicador', $indicador->indicador) }}</textarea>
                                @error('indicador')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="objetivo" class="col-md-3 col-form-label text-md-right">Objetivo</label>
                            <div class="col-md-9">
                                <textarea id="objetivo" class="form-control @error('objetivo') is-invalid @enderror"
                                    name="objetivo" required rows="3">{{ old('objetivo', $indicador->objetivo) }}</textarea>
                                @error('objetivo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cod_tipo_indicador" class="col-md-3 col-form-label text-md-right">Tipo de Indicador</label>
                            <div class="col-md-9">
                                <select id="cod_tipo_indicador" class="form-control @error('cod_tipo_indicador') is-invalid @enderror"
                                    name="cod_tipo_indicador" required>
                                    <option value="">Seleccione un tipo</option>
                                    @foreach($tiposIndicador as $tipo)
                                    <option value="{{ $tipo->cod_tipo_indicador }}"
                                        {{ (old('cod_tipo_indicador', $indicador->cod_tipo_indicador) == $tipo->cod_tipo_indicador) ? 'selected' : '' }}>
                                        {{ $tipo->tipo_indicador }} - {{ $tipo->descripcion }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('cod_tipo_indicador')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="meta" class="col-md-3 col-form-label text-md-right">Meta</label>
                            <div class="col-md-9">
                                <input id="meta" type="number" step="0.01" class="form-control @error('meta') is-invalid @enderror"
                                    name="meta" value="{{ old('meta', $indicador->meta) }}" required>
                                @error('meta')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cod_usuario" class="col-md-3 col-form-label text-md-right">Asignar a</label>
                            <div class="col-md-9">
                                <select id="cod_usuario" class="form-control @error('cod_usuario') is-invalid @enderror"
                                    name="cod_usuario" required>
                                    <option value="">Seleccione un usuario</option>
                                    @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->cod_usuario }}"
                                        {{ old('cod_usuario', $indicador->cod_usuario) == $usuario->cod_usuario ? 'selected' : '' }}>
                                        {{ $usuario->nombre }} ({{ $usuario->departamento->departamento ?? 'N/A' }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('cod_usuario')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">Archivos Actuales</label>
                            <div class="col-md-9">
                                @if($indicador->archivos->count() > 0)
                                <div class="list-group">
                                    @foreach($indicador->archivos as $archivo)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="{{ route('archivos.download', $archivo) }}" target="_blank">
                                            <i class="fas fa-file mr-2"></i>{{ $archivo->nombre_original }}
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirmarEliminarArchivo({{ $archivo->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <p class="text-muted">No hay archivos adjuntos</p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="archivos" class="col-md-3 col-form-label text-md-right">Nuevos Archivos</label>
                            <div class="col-md-9">
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
                            <div class="col-md-9 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Actualizar Indicador
                                </button>
                                <a href="{{ route('indicadores.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <form id="delete-file-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@stop

@section('js')
    <script>
        function confirmarEliminarArchivo(archivoId) {
            if (confirm('¿Está seguro que desea eliminar este archivo?')) {
                const form = document.getElementById('delete-file-form');
                form.action = `/archivos/${archivoId}`;
                form.submit();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Validación de tamaño máximo de archivos (10MB)
            const fileInput = document.getElementById('archivos');
            const maxSize = 10 * 1024 * 1024; // 10MB en bytes
            //
            fileInput.addEventListener('change', function() {
                const files = this.files;
                let totalSize = 0;

                for (let i = 0; i < files.length; i++) {
                    totalSize += files[i].size;
                }

                if (totalSize > maxSize) {
                    alert('El tamaño total de los archivos no puede exceder los 10MB');
                    this.value = ''; // Limpiar la selección
                }
            });
        });
    </script>
@endsection
