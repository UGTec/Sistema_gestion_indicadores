@extends('layouts.app')

@section('subtitle', 'Editar Iframe: ' . $iframe->name)
@section('content_header_title', 'Editar Iframe')
@section('content_header_subtitle', 'Modifica los detalles del iframe seleccionado.')

@section('content_body')

<!-- Display success message if available -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('warning'))
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
    </div>
@endif
<!-- Card for editing iframe -->
<x-adminlte-card class="shadow" title="Editar Iframe: {{ $iframe->name }}" theme="primary" icon="fas fa-lg fa-iframe" collapsible maximizable>
    <x-slot name="toolsSlot">
        <a href="{{ route('iframes.index') }}" class="btn btn-secondary btn-xs" title="Volver a la lista de Iframes">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </x-slot>
    <form action="{{ route('iframes.update', $iframe) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre *</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                id="name"
                name="name"
                value="{{ old('name', $iframe->name) }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="url" class="form-label">URL *</label>
            <input type="url" class="form-control @error('url') is-invalid @enderror" id="url" name="url"
                value="{{ old('url', $iframe->url) }}"
                placeholder="https://ejemplo.com">
                @error('url')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                name="description"
                rows="3">{{ old('description', $iframe->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="width" class="form-label">Ancho *</label>
                    <input type="text" class="form-control @error('width') is-invalid @enderror" id="width" name="width"
                        value="{{ old('width', $iframe->width) }}"
                        placeholder="ej: 100%, 800px, auto">
                    <div class="form-text">
                        Acepta: números (se agrega px), porcentajes (%), píxeles (px), auto, inherit, em, rem, vh, vw
                    </div>
                    @error('width')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="height" class="form-label">Alto *</label>
                    <input type="text" class="form-control @error('height') is-invalid @enderror" id="height"
                        name="height"
                        value="{{ old('height', $iframe->height) }}"
                        placeholder="ej: 100%, 600px, auto">
                    <div class="form-text">
                        Acepta: números (se agrega px), porcentajes (%), píxeles (px), auto, inherit, em, rem, vh, vw
                    </div>
                    @error('height')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input"
                    type="checkbox"
                    id="is_active"
                    name="is_active"
                    value="1"
                    {{ old('is_active', $iframe->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">
                    <strong>Activo</strong>
                </label>
                <div class="form-text text-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    Solo puede haber un iframe activo a la vez. Al activar este, se desactivarán todos los demás.
                </div>
            </div>
        </div>

        <!-- Vista previa del iframe -->
        <div class="mb-3" id="preview-container" style="display: none;">
            <label class="form-label">Vista Previa</label>
            <div class="border p-2" style="background-color: #f8f9fa;">
                <iframe id="preview-iframe"
                    src=""
                    style="border: 1px solid #dee2e6; max-width: 100%;"
                    width="400"
                    height="300">
                </iframe>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('iframes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Actualizar
            </button>
        </div>
    </form>
</x-adminlte-card>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">

        </div>
    </div>
</div>

@stop
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlInput = document.getElementById('url');
            const previewContainer = document.getElementById('preview-container');
            const previewIframe = document.getElementById('preview-iframe');
            const widthInput = document.getElementById('width');
            const heightInput = document.getElementById('height');

            function updatePreview() {
                const url = urlInput.value;
                const width = widthInput.value || '800px';
                const height = heightInput.value || '600px';

                if (url && isValidUrl(url)) {
                    previewIframe.src = url;

                    // Configurar dimensiones del preview (limitado para la vista previa)
                    const previewWidth = parseSize(width, 400);
                    const previewHeight = parseSize(height, 300);

                    previewIframe.style.width = previewWidth;
                    previewIframe.style.height = previewHeight;
                    previewContainer.style.display = 'block';
                } else {
                    previewContainer.style.display = 'none';
                }
            }

            function parseSize(size, maxSize) {
                // Si es porcentaje o auto, usar el tamaño máximo para preview
                if (size.includes('%') || size === 'auto' || size === 'inherit') {
                    return maxSize + 'px';
                }

                // Extraer número de la unidad
                const num = parseInt(size);
                if (isNaN(num)) return maxSize + 'px';
                // Limitar al tamaño máximo para preview
                return Math.min(num, maxSize) + 'px';
            }

            function isValidUrl(string) {
                try {
                    new URL(string);
                    return true;
                } catch (_) {
                    return false;
                }
            }

            urlInput.addEventListener('input', updatePreview);
            widthInput.addEventListener('input', updatePreview);
            heightInput.addEventListener('input', updatePreview);

            // Mostrar preview inicial si hay URL
            updatePreview();
        });
    </script>
@endpush
