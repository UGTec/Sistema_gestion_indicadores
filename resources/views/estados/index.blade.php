@extends('layouts.app')

@section('title', 'Estados de Usuario')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Listado de Estados de Usuario</h5>
        <a href="{{ route('estados.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nuevo Estado
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
                        <th>Estado</th>
                        <th>Usuarios</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($estados as $estado)
                    <tr>
                        <td>{{ $estado->cod_estado_usuario }}</td>
                        <td>
                            <span class="badge badge-{{ $estado->cod_estado_usuario == 1 ? 'success' : 'danger' }}">
                                {{ $estado->estado_usuario }}
                            </span>
                        </td>
                        <td>{{ $estado->usuarios->count() }}</td>
                        <td>
                            <a href="{{ route('estados.show', $estado->cod_estado_usuario) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('estados.edit', $estado->cod_estado_usuario) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('estados.destroy', $estado->cod_estado_usuario) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este estado?')">
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
