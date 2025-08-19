@extends('layouts.app')

@section('title', 'Detalles del Iframe')
@section('subtitle', 'Información detallada del iframe seleccionado')
@section('content_header_title', 'Detalles del Iframe')
@section('content_header_subtitle', 'Aquí puedes ver y gestionar los detalles del iframe.')

@section('content_body')

<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Detalles del Iframe: {{ $iframe->name }}</h4>
                <div class="btn-group">
                    <a href="{{ route('iframes.edit', $iframe) }}" class="btn btn-golden">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    @if($iframe->is_active)
                        <a href="{{ route('iframe.display', $iframe) }}"
                            class="btn btn-forest"
                            target="_blank">
                            <i class="fas fa-external-link-alt"></i> Ver Iframe
                        </a>
                    @endif
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6><strong>Información General</strong></h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="30%"><strong>ID:</strong></td>
                                <td>{{ $iframe->id }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nombre:</strong></td>
                                <td>{{ $iframe->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Estado:</strong></td>
                                <td>
                                    @if($iframe->is_active)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle"></i> Activo
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-times-circle"></i> Inactivo
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Creado:</strong></td>
                                <td>{{ $iframe->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Actualizado:</strong></td>
                                <td>{{ $iframe->updated_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h6><strong>Configuración Técnica</strong></h6>
                        <table class="table table-borderless">
                            <tr>
                                <td width="30%"><strong>URL:</strong></td>
                                <td>
                                    <div class="input-group">
                                        <input type="text"
                                                class="form-control form-control-sm"
                                                value="{{ $iframe->url }}"
                                                readonly>
                                        <button class="btn btn-outline-secondary btn-sm"
                                                type="button"
                                                onclick="copyToClipboard('{{ $iframe->url }}')">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Ancho:</strong></td>
                                <td><code>{{ $iframe->width }}</code></td>
                            </tr>
                            <tr>
                                <td><strong>Alto:</strong></td>
                                <td><code>{{ $iframe->height }}</code></td>
                            </tr>
                            <tr>
                                <td><strong>URL Válida:</strong></td>
                                <td>
                                    @if($iframe->isValidUrl())
                                        <span class="text-success">
                                            <i class="fas fa-check"></i> Sí
                                        </span>
                                    @else
                                        <span class="text-danger">
                                            <i class="fas fa-times"></i> No
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($iframe->description)
                    <div class="mb-4">
                        <h6><strong>Descripción</strong></h6>
                        <div class="alert alert-info">
                            {{ $iframe->description }}
                        </div>
                    </div>
                @endif

                <!-- Código HTML para embebido -->
                <div class="mb-4">
                    <h6><strong>Código HTML para Embebido</strong></h6>
                    <div class="bg-light p-3 rounded">
                        <code id="embed-code">
                            &lt;iframe src="{{ route('iframe.display', $iframe) }}"
                                width="{{ $iframe->width }}"
                                height="{{ $iframe->height }}"
                                frameborder="0"
                                title="{{ $iframe->name }}"&gt;
                            &lt;/iframe&gt;
                        </code>
                        <div class="mt-2">
                            <button class="btn btn-sm btn-outline-primary" onclick="copyEmbedCode()">
                                <i class="fas fa-copy"></i> Copiar Código
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Vista previa del iframe -->
                @if($iframe->isValidUrl())
                    <div class="mb-4">
                        <h6><strong>Vista Previa</strong></h6>
                        <div class="border rounded p-3" style="background-color: #f8f9fa;">
                            <div class="d-flex justify-content-center">
                                <iframe src="{{ $iframe->url }}"
                                        style="border: 1px solid #dee2e6; max-width: 100%;"
                                        width="800"
                                        height="400"
                                        title="{{ $iframe->name }}">
                                    <p>Tu navegador no soporta iframes.</p>
                                </iframe>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Advertencia:</strong> La URL no es válida, no se puede mostrar la vista previa.
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('iframes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver al Listado
                    </a>

                    <div class="btn-group">
                        <a href="{{ route('iframes.edit', $iframe) }}" class="btn btn-orange">
                            <i class="fas fa-edit"></i> Editar
                        </a>

                        <form action="{{ route('iframes.destroy', $iframe) }}"
                                method="POST"
                                style="display: inline;"
                                onsubmit="return confirm('¿Estás seguro de que quieres eliminar este iframe?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-coral">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@push('js')
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // Mostrar notificación de éxito
            showNotification('URL copiada al portapapeles', 'success');
        },
        function(err) {
            console.error('Error al copiar: ', err);
            showNotification('Error al copiar URL', 'error');
        });
    }
    function copyEmbedCode() {
        const embedCode = document.getElementById('embed-code').textContent;
        navigator.clipboard.writeText(embedCode).then(function() {
            showNotification('Código HTML copiado al portapapeles', 'success');
        }, function(err) {
            console.error('Error al copiar: ', err);
            showNotification('Error al copiar código', 'error');
        });
    }
    function showNotification(message, type) {
        // Crear elemento de notificación
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `<i class="fas fa-${type === 'success' ? 'check' : 'times'}-circle"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;

        document.body.appendChild(notification);

        // Remover después de 3 segundos
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
</script>
@endpush
