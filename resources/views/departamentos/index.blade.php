@extends('layouts.app')

@section('title', 'Listado de Departamentos')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Listado de Departamentos</h5>
        <a href="{{ route('departamentos.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nuevo Departamento
        </a>
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
                        <th>Departamento</th>
                        <th>División</th>
                        <th>Usuarios</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departamentos as $departamento)
                    <tr>
                        <td>{{ $departamento->cod_departamento }}</td>
                        <td>{{ $departamento->departamento }}</td>
                        <td>{{ $departamento->division->division ?? 'N/A' }}</td>
                        <td>{{ $departamento->usuarios->count() }}</td>
                        <td>
                            <a href="{{ route('departamentos.show', $departamento->cod_departamento) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('departamentos.edit', $departamento->cod_departamento) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('departamentos.destroy', $departamento->cod_departamento) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este departamento?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
