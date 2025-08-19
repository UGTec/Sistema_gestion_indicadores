@extends('layouts.app')

@section('title', 'Crear Indicador')
@section('subtitle', 'Formulario para crear un nuevo indicador')
@section('content_header_title', 'Crear Nuevo Indicador')
@section('content_header_subtitle', 'Formulario para crear un nuevo indicador')

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

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Crear Nuevo Indicador</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('indicadores.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="indicador" class="col-md-3 col-form-label text-md-right">Nombre del Indicador</label>
                            <div class="col-md-9">
                                <textarea id="indicador" class="form-control @error('indicador') is-invalid @enderror"
                                    name="indicador"  autofocus rows="3">{{ old('indicador') }}</textarea>
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
                                    name="objetivo"  rows="3">{{ old('objetivo') }}</textarea>
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
                                    name="cod_tipo_indicador" >
                                    <option value="">Seleccione un tipo</option>
                                    @foreach($tiposIndicador as $tipo)
                                    <option value="{{ $tipo->cod_tipo_indicador }}" {{ old('cod_tipo_indicador') == $tipo->cod_tipo_indicador ? 'selected' : '' }}>
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
                                    name="meta" value="{{ old('meta') }}" >
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
                                    name="cod_usuario" >
                                    <option value="">Seleccione un usuario</option>
                                    @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->cod_usuario }}" {{ old('cod_usuario') == $usuario->cod_usuario ? 'selected' : '' }}>
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
                            <label for="archivos" class="col-md-3 col-form-label text-md-right">Archivos Adjuntos</label>
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
                                    <i class="fas fa-save"></i> Guardar Indicador
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

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación de tamaño máximo de archivos (10MB)
    const fileInput = document.getElementById('archivos');
    const maxSize = 10 * 1024 * 1024; // 10MB en bytes

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
