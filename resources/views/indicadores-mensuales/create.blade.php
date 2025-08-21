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
                    <h5 class="mb-0">Nuevo Registro Mensual para: {{ $indicador->indicador }}</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('indicadores-mensuales.store', $indicador) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="mes" class="col-md-4 col-form-label text-md-right">Mes</label>
                            <div class="col-md-6">
                                <select id="mes" class="form-control @error('mes') is-invalid @enderror" name="mes" >
                                    @foreach(range(1, 12) as $month)
                                    <option value="{{ $month }}" {{ old('mes', \Carbon\Carbon::now()->month) == $month ? 'selected' : '' }}>
                                        {{ ucfirst(\Carbon\Carbon::create()->month($month)->locale('es')->monthName) }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('mes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="año" class="col-md-4 col-form-label text-md-right">Año</label>
                            <div class="col-md-6">
                                <input id="año" type="number" class="form-control @error('año') is-invalid @enderror"
                                    name="año" value="{{ old('año', date('Y')) }}" min="2000" max="{{ date('Y')+1 }}" >
                                @error('año')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="numerador" class="col-md-4 col-form-label text-md-right">Numerador</label>
                            <div class="col-md-6">
                                <input id="numerador" type="number" step="0.01" class="form-control @error('numerador') is-invalid @enderror"
                                    name="numerador" value="{{ old('numerador') }}" >
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
                                    name="denominador" value="{{ old('denominador') }}" >
                                @error('denominador')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="comentarios" class="col-md-4 col-form-label text-md-right">Comentarios</label>
                            <div class="col-md-6">
                                <textarea id="comentarios" class="form-control @error('comentarios') is-invalid @enderror"
                                    name="comentarios" rows="3">{{ old('comentarios') }}</textarea>
                                @error('comentarios')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Guardar Registro
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
