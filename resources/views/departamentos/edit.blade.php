@extends('layouts.app')

@section('title', 'Editar Departamento')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Editar Departamento</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('departamentos.update', $departamento->cod_departamento) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="cod_departamento">Código</label>
                    <input type="number" class="form-control" id="cod_departamento" name="cod_departamento"
                           value="{{ $departamento->cod_departamento }}" readonly>
                </div>
                <div class="form-group col-md-7">
                    <label for="departamento">Nombre Departamento</label>
                    <input type="text" class="form-control" id="departamento" name="departamento"
                           value="{{ $departamento->departamento }}" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="cod_division">División</label>
                    <select class="form-control" id="cod_division" name="cod_division" required>
                        <option value="">Seleccione una división</option>
                        @foreach($divisions as $division)
                            <option value="{{ $division->cod_division }}"
                                {{ $departamento->cod_division == $division->cod_division ? 'selected' : '' }}>
                                {{ $division->division }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar
                </button>
                <a href="{{ route('departamentos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
