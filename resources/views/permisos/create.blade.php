@extends('layouts.app')

@section('title', 'Crear Nuevos Permisos')
@section('subtitle', 'Crear Permisos')
@section('content_header_title', 'Crear Nuevos Permisos')
@section('content_header_subtitle', 'Definir nuevos permisos para los módulos del sistema')

@section('content_body')
    {{-- Display validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <x-adminlte-card class="shadow" title="Crear Nuevos Permisos" theme="primary" icon="fas fa-lg fa-lock" collapsible maximizable>
        <form action="{{ route('permisos.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Módulo</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Nombre del módulo">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Nombre del módulo (ej: usuarios, roles, etc.)</small>
            </div>

            <div class="form-group">
                <label>Acciones</label>
                @error('permissions')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div id="permissions-container">
                    @if(old('permissions'))
                        @foreach(old('permissions') as $index => $permission)
                            <div class="input-group mb-2">
                                <input type="text" class="form-control @error('permissions.'.$index) is-invalid @enderror"
                                    name="permissions[]" value="{{ $permission }}"
                                    placeholder="Nombre del permiso (ej: crear, editar)">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-danger remove-permission" type="button">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                @error('permissions.'.$index)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endforeach
                    @else
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="permissions[]"
                                placeholder="Nombre del permiso (ej: crear, editar)">
                            <div class="input-group-append">
                                <button class="btn btn-outline-danger remove-permission" type="button">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
                {{-- <div id="permissions-container">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" name="permissions[]" placeholder="Nombre del permiso (ej: crear, editar)">
                        <div class="input-group-append">
                            <button class="btn btn-outline-danger remove-permission" type="button">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div> --}}
                <button type="button" id="add-permission" class="btn btn-sm btn-secondary">
                    <i class="fas fa-plus"></i> Agregar Acción
                </button>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Permisos
                </button>
                <a href="{{ route('permisos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </div>
        </form>
    </x-adminlte-card>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Agregar nuevo campo de permiso
            $('#add-permission').click(function() {
                const newField = `
                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="permissions[]"
                    placeholder="Nombre del permiso (ej: crear, editar)">
                    <div class="input-group-append">
                        <button class="btn btn-outline-danger remove-permission" type="button">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>`;
                $('#permissions-container').append(newField);
            });

            // Eliminar campo de permiso
            $(document).on('click', '.remove-permission', function() {
                if ($('#permissions-container .input-group').length > 1) {
                    $(this).closest('.input-group').remove();
                } else {
                    alert('Debe haber al menos un permiso');
                }
            });
        });
        // $(document).ready(function() {
        //     $('#add-permission').click(function() {
        //         $('#permissions-container').append(`
        //             <div class="input-group mb-2">
        //                 <input type="text" class="form-control" name="permissions[]" placeholder="Nombre del permiso (ej: crear, editar)">
        //                 <div class="input-group-append">
        //                     <button class="btn btn-outline-danger remove-permission" type="button">
        //                         <i class="fas fa-times"></i>
        //                     </button>
        //                 </div>
        //             </div>
        //         `);
        //     });

        //     $(document).on('click', '.remove-permission', function() {
        //         $(this).closest('.input-group').remove();
        //     });
        // });
    </script>
@endsection
