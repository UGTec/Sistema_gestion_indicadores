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
                    <form method="POST" action="{{ route('indicadores-mensuales.update', [$indicador, $mensual]) }}">
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
@endsection
