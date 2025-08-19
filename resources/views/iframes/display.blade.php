<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $iframe->name }}</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .iframe-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin: 0 auto;
            max-width: calc(100vw - 40px);
            width: fit-content;
        }
        .iframe-header {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .iframe-title {
            margin: 0;
            color: #333;
            font-size: 1.2em;
        }
        .iframe-description {
            color: #666;
            margin: 5px 0 0 0;
            font-size: 0.9em;
        }
        .iframe-wrapper {
            position: relative;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }
        .iframe-content {
            display: block;
            width: {{ $iframe->width }};
            height: {{ $iframe->height }};
            border: none;
            background: white;
            max-width: 100%;
        }
        .loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #666;
            font-size: 14px;
        }
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 4px;
            text-align: center;
        }
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            .iframe-container {
                padding: 15px;
            }
            .iframe-content {
                width: 100%;
                height: 400px;
            }
        }
    </style>
</head>
<body>
    <div class="iframe-container">
        <div class="iframe-header">
            <h1 class="iframe-title">{{ $iframe->name }}</h1>
            @if($iframe->description)
                <p class="iframe-description">{{ $iframe->description }}</p>
            @endif
        </div>

        <div class="iframe-wrapper">
            @if($iframe->isValidUrl())
                <div class="loading" id="loading">Cargando contenido...</div>
                <iframe
                    class="iframe-content"
                    src="{{ $iframe->url }}"
                    title="{{ $iframe->name }}"
                    loading="lazy"
                    onload="document.getElementById('loading').style.display='none'"
                    onerror="showError()">
                    <p>Tu navegador no soporta iframes.
                       <a href="{{ $iframe->url }}" target="_blank">Haz clic aquí para ver el contenido</a>
                    </p>
                </iframe>
            @else
                <div class="error-message">
                    <strong>Error:</strong> La URL no es válida o no se puede cargar.
                    <br>
                    <a href="{{ $iframe->url }}" target="_blank">Intentar abrir en nueva ventana</a>
                </div>
            @endif
        </div>
    </div>

    <script>
        function showError() {
            document.getElementById('loading').style.display = 'none';
            const iframe = document.querySelector('.iframe-content');
            iframe.style.display = 'none';

            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.innerHTML = `
                <strong>Error al cargar el contenido</strong><br>
                El sitio web podría no permitir ser mostrado en un iframe por razones de seguridad.<br>
                <a href="{{ $iframe->url }}" target="_blank">Abrir en nueva ventana</a>
            `;

            document.querySelector('.iframe-wrapper').appendChild(errorDiv);
        }

        // Ocultar loading después de 10 segundos si no se ha cargado
        setTimeout(function() {
            const loading = document.getElementById('loading');
            if (loading && loading.style.display !== 'none') {
                loading.style.display = 'none';
            }
        }, 10000);
    </script>
</body>
</html>
