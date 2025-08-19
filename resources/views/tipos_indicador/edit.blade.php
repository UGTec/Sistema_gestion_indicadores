@extends('layouts.app')

@section('title', 'Editar Tipo de Indicador')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Editar Tipo: {{ $tipo->tipo_indicador }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('tipos_indicador.update', $tipo->cod_tipo_indicador) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="cod_tipo_indicador">Código</label>
                    <input type="number" class="form-control" id="cod_tipo_indicador"
                           name="cod_tipo_indicador" value="{{ $tipo->cod_tipo_indicador }}" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="tipo_indicador">Tipo</label>
                    <input type="text" class="form-control" id="tipo_indicador"
                           name="tipo_indicador" value="{{ $tipo->tipo_indicador }}" maxlength="10" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="descripcion">Descripción</label>
                    <input type="text" class="form-control" id="descripcion"
                           name="descripcion" value="{{ $tipo->descripcion }}" maxlength="75" required>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar
                </button>
                <a href="{{ route('tipos_indicador.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
