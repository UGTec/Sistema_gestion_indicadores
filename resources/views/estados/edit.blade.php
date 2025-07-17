@extends('layouts.app')

@section('title', 'Editar Estado de Usuario')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Editar Estado</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('estados.update', $estado->cod_estado_usuario) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="cod_estado_usuario">Código</label>
                    <input type="number" class="form-control" id="cod_estado_usuario"
                           name="cod_estado_usuario" value="{{ $estado->cod_estado_usuario }}" readonly>
                </div>
                <div class="form-group col-md-10">
                    <label for="estado_usuario">Nombre del Estado</label>
                    <input type="text" class="form-control" id="estado_usuario"
                           name="estado_usuario" value="{{ $estado->estado_usuario }}" required>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar
                </button>
                <a href="{{ route('estados.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
