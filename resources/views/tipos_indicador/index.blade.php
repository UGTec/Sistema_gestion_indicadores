@extends('layouts.app')

@section('title', 'Tipos de Indicador')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Listado de Tipos de Indicador</h5>
        @can('tipos_indicador.create')
        <a href="{{ route('tipos_indicador.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nuevo Tipo
        </a>
        @endcan
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Código</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Indicadores</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tipos as $tipo)
                    <tr>
                        <td>{{ $tipo->cod_tipo_indicador }}</td>
                        <td>{{ $tipo->tipo_indicador }}</td>
                        <td>{{ $tipo->descripcion }}</td>
                        <td>{{ $tipo->indicadores->count() }}</td>
                        <td>
                            <a href="{{ route('tipos_indicador.show', $tipo->cod_tipo_indicador) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            @can('tipos_indicador.edit')
                            <a href="{{ route('tipos_indicador.edit', $tipo->cod_tipo_indicador) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan
                            @can('tipos_indicador.destroy')
                            <form action="{{ route('tipos_indicador.destroy', $tipo->cod_tipo_indicador) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este tipo?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
