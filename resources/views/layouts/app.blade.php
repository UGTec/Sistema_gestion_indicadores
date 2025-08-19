@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title')
    {{ config('adminlte.title') }}
    @hasSection('subtitle') | @yield('subtitle') @endif
@stop

{{-- Extend and customize the page content header --}}

@section('content_header')
    @hasSection('content_header_title')
        <h1 class="text-muted">
            @yield('content_header_title')

            @hasSection('content_header_subtitle')
                <small class="text-dark">
                    <i class="fas fa-xs fa-angle-right text-muted"></i>
                    @yield('content_header_subtitle')
                </small>
            @endif
        </h1>
    @endif
@stop

{{-- Rename section content to content_body --}}

@section('content')
    @yield('content_body')
@stop

{{-- Create a common footer --}}

@section('footer')
    {{-- <div class="float-right">
        Version: {{ config('app.version', '1.0.0') }}
    </div>

    <strong>
        <a href="{{ config('app.company_url', '#') }}">
            {{ config('app.company_name', 'SCG') }}
        </a>
    </strong> --}}
@stop

{{-- Add common Javascript/Jquery code --}}

@push('js')
<script>
    $(document).ready(function() {
        // Add your common script logic here...
    });
</script>
@endpush

{{-- Add common CSS customizations --}}

@push('css')
<style type="text/css">
/* ========================================
   BOOTSTRAP 4.6 - PALETA DE COLORES PERSONALIZADA
   ======================================== */

:root {
    /* Colores base personalizados */
    --blue: #3FA9F5;
    --indigo: #175BBD;
    --purple: #6f42c1;
    --pink: #F15953;
    --red: #E73439;
    --orange: #EB6E44;
    --yellow: #F2C525;
    --green: #529140;
    --teal: #20c997;
    --cyan: #3FA9F5;
    --white: #fff;
    --gray: #6c757d;
    --gray-dark: #343a40;
    --light-pink: #FFC5B6;
    --light-blue: #B8E6FF;
    --light-cream: #FEF3E5;
    /* Colores semánticos */
    --primary: #175BBD;
    --secondary: #6c757d;
    --success: #529140;
    --info: #3FA9F5;
    --warning: #F2C525;
    --danger: #E73439;
    --light: #f8f9fa;
    --dark: #343a40;
}

/* ========================================
   UTILIDADES DE COLOR
   ======================================== */

/* Colores de texto */
.text-coral { color: #F15953 !important; }
.text-orange { color: #EB6E44 !important; }
.text-light-pink { color: #FFC5B6 !important; }
.text-navy { color: #175BBD !important; }
.text-sky-blue { color: #3FA9F5 !important; }
.text-light-blue { color: #B8E6FF !important; }
.text-golden { color: #F2C525 !important; }
.text-forest { color: #529140 !important; }
.text-cream { color: #FEF3E5 !important; }

/* Colores de fondo */
.bg-coral { background-color: #F15953 !important; }
.bg-orange { background-color: #EB6E44 !important; }
.bg-light-pink { background-color: #FFC5B6 !important; }
.bg-navy { background-color: #175BBD !important; }
.bg-sky-blue { background-color: #3FA9F5 !important; }
.bg-light-blue { background-color: #B8E6FF !important; }
.bg-golden { background-color: #F2C525 !important; }
.bg-forest { background-color: #529140 !important; }
.bg-cream { background-color: #FEF3E5 !important; }

/* ========================================
   BOTONES PERSONALIZADOS
   ======================================== */

/* Botón Coral */
.btn-coral {
    color: #fff;
    background-color: #F15953;
    border-color: #F15953;
}

.btn-coral:hover {
    color: #fff;
    background-color: #e04439;
    border-color: #dc3e33;
}

.btn-coral:focus, .btn-coral.focus {
    color: #fff;
    background-color: #e04439;
    border-color: #dc3e33;
    box-shadow: 0 0 0 0.2rem rgba(241, 89, 83, 0.5);
}

.btn-coral.disabled, .btn-coral:disabled {
    color: #fff;
    background-color: #F15953;
    border-color: #F15953;
}

.btn-coral:not(:disabled):not(.disabled):active, .btn-coral:not(:disabled):not(.disabled).active {
    color: #fff;
    background-color: #dc3e33;
    border-color: #d73a2f;
}

/* Botón Orange */
.btn-orange {
    color: #fff;
    background-color: #EB6E44;
    border-color: #EB6E44;
}

.btn-orange:hover {
    color: #fff;
    background-color: #e55a32;
    border-color: #e2542c;
}

.btn-orange:focus, .btn-orange.focus {
    color: #fff;
    background-color: #e55a32;
    border-color: #e2542c;
    box-shadow: 0 0 0 0.2rem rgba(235, 110, 68, 0.5);
}

/* Botón Navy */
.btn-navy {
    color: #fff;
    background-color: #175BBD;
    border-color: #175BBD;
}

.btn-navy:hover {
    color: #fff;
    background-color: #144ea1;
    border-color: #134996;
}

.btn-navy:focus, .btn-navy.focus {
    color: #fff;
    background-color: #144ea1;
    border-color: #134996;
    box-shadow: 0 0 0 0.2rem rgba(23, 91, 189, 0.5);
}

/* Botón Sky Blue */
.btn-sky-blue {
    color: #fff;
    background-color: #3FA9F5;
    border-color: #3FA9F5;
}

.btn-sky-blue:hover {
    color: #fff;
    background-color: #2a9df3;
    border-color: #1f99f2;
}

.btn-sky-blue:focus, .btn-sky-blue.focus {
    color: #fff;
    background-color: #2a9df3;
    border-color: #1f99f2;
    box-shadow: 0 0 0 0.2rem rgba(63, 169, 245, 0.5);
}

/* Botón Golden */
.btn-golden {
    color: #212529;
    background-color: #F2C525;
    border-color: #F2C525;
}

.btn-golden:hover {
    color: #212529;
    background-color: #f0c009;
    border-color: #efbe02;
}

.btn-golden:focus, .btn-golden.focus {
    color: #212529;
    background-color: #f0c009;
    border-color: #efbe02;
    box-shadow: 0 0 0 0.2rem rgba(242, 197, 37, 0.5);
}

/* Botón Forest */
.btn-forest {
    color: #fff;
    background-color: #529140;
    border-color: #529140;
}

.btn-forest:hover {
    color: #fff;
    background-color: #468037;
    border-color: #417733;
}

.btn-forest:focus, .btn-forest.focus {
    color: #fff;
    background-color: #468037;
    border-color: #417733;
    box-shadow: 0 0 0 0.2rem rgba(82, 145, 64, 0.5);
}

/* ========================================
   BOTONES OUTLINE PERSONALIZADOS
   ======================================== */

.btn-outline-coral {
    color: #F15953;
    border-color: #F15953;
}

.btn-outline-coral:hover {
    color: #fff;
    background-color: #F15953;
    border-color: #F15953;
}

.btn-outline-coral:focus, .btn-outline-coral.focus {
    box-shadow: 0 0 0 0.2rem rgba(241, 89, 83, 0.5);
}

.btn-outline-orange {
    color: #EB6E44;
    border-color: #EB6E44;
}

.btn-outline-orange:hover {
    color: #fff;
    background-color: #EB6E44;
    border-color: #EB6E44;
}

.btn-outline-orange:focus, .btn-outline-orange.focus {
    box-shadow: 0 0 0 0.2rem rgba(235, 110, 68, 0.5);
}

.btn-outline-navy {
    color: #175BBD;
    border-color: #175BBD;
}

.btn-outline-navy:hover {
    color: #fff;
    background-color: #175BBD;
    border-color: #175BBD;
}

.btn-outline-navy:focus, .btn-outline-navy.focus {
    box-shadow: 0 0 0 0.2rem rgba(23, 91, 189, 0.5);
}

.btn-outline-sky-blue {
    color: #3FA9F5;
    border-color: #3FA9F5;
}

.btn-outline-sky-blue:hover {
    color: #fff;
    background-color: #3FA9F5;
    border-color: #3FA9F5;
}

.btn-outline-sky-blue:focus, .btn-outline-sky-blue.focus {
    box-shadow: 0 0 0 0.2rem rgba(63, 169, 245, 0.5);
}

.btn-outline-golden {
    color: #F2C525;
    border-color: #F2C525;
}

.btn-outline-golden:hover {
    color: #212529;
    background-color: #F2C525;
    border-color: #F2C525;
}

.btn-outline-golden:focus, .btn-outline-golden.focus {
    box-shadow: 0 0 0 0.2rem rgba(242, 197, 37, 0.5);
}

.btn-outline-forest {
    color: #529140;
    border-color: #529140;
}

.btn-outline-forest:hover {
    color: #fff;
    background-color: #529140;
    border-color: #529140;
}

.btn-outline-forest:focus, .btn-outline-forest.focus {
    box-shadow: 0 0 0 0.2rem rgba(82, 145, 64, 0.5);
}

/* ========================================
   TAMAÑOS DE BOTONES
   ======================================== */

/* Botón Extra Large (personalizado) */
.btn-xl {
    padding: 1rem 2rem;
    font-size: 1.25rem;
    line-height: 1.5;
    border-radius: 0.5rem;
}

/* Botón Large */
.btn-lg {
    padding: 0.5rem 1rem;
    font-size: 1.25rem;
    line-height: 1.5;
    border-radius: 0.3rem;
}

/* Botón Normal (ya incluido en Bootstrap) */
.btn {
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.25rem;
}

/* Botón Small */
.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.2rem;
}

/* Botón Extra Small (personalizado) */
.btn-xs {
    padding: 0.125rem 0.375rem;
    font-size: 0.75rem;
    line-height: 1.5;
    border-radius: 0.15rem;
}

/* ========================================
   ACTUALIZACIÓN DE COLORES BOOTSTRAP
   ======================================== */

/* Primary actualizado */
.btn-primary {
    background-color: #175BBD;
    border-color: #175BBD;
}

.btn-primary:hover {
    background-color: #144ea1;
    border-color: #134996;
}

.btn-outline-primary {
    color: #175BBD;
    border-color: #175BBD;
}

.btn-outline-primary:hover {
    background-color: #175BBD;
    border-color: #175BBD;
}

/* Success actualizado */
.btn-success {
    background-color: #529140;
    border-color: #529140;
}

.btn-success:hover {
    background-color: #468037;
    border-color: #417733;
}

.btn-outline-success {
    color: #529140;
    border-color: #529140;
}

.btn-outline-success:hover {
    background-color: #529140;
    border-color: #529140;
}

/* Info actualizado */
.btn-info {
    background-color: #3FA9F5;
    border-color: #3FA9F5;
}

.btn-info:hover {
    background-color: #2a9df3;
    border-color: #1f99f2;
}

.btn-outline-info {
    color: #3FA9F5;
    border-color: #3FA9F5;
}

.btn-outline-info:hover {
    background-color: #3FA9F5;
    border-color: #3FA9F5;
}

/* Warning actualizado */
.btn-warning {
    background-color: #F2C525;
    border-color: #F2C525;
    color: #212529;
}

.btn-warning:hover {
    background-color: #f0c009;
    border-color: #efbe02;
    color: #212529;
}

.btn-outline-warning {
    color: #F2C525;
    border-color: #F2C525;
}

.btn-outline-warning:hover {
    background-color: #F2C525;
    border-color: #F2C525;
    color: #212529;
}

/* Danger actualizado */
.btn-danger {
    background-color: #E73439;
    border-color: #E73439;
}

.btn-danger:hover {
    background-color: #dc2429;
    border-color: #d01f25;
}

.btn-outline-danger {
    color: #E73439;
    border-color: #E73439;
}

.btn-outline-danger:hover {
    background-color: #E73439;
    border-color: #E73439;
}

/* ========================================
   GRUPOS DE BOTONES Y ESTADOS
   ======================================== */

/* Botones en grupo */
.btn-group > .btn-coral:not(:first-child),
.btn-group > .btn-orange:not(:first-child),
.btn-group > .btn-navy:not(:first-child),
.btn-group > .btn-sky-blue:not(:first-child),
.btn-group > .btn-golden:not(:first-child),
.btn-group > .btn-forest:not(:first-child) {
    margin-left: -1px;
}

/* Estados activos para botones personalizados */
.btn-coral:not(:disabled):not(.disabled):active,
.btn-coral:not(:disabled):not(.disabled).active,
.show > .btn-coral.dropdown-toggle {
    background-color: #dc3e33;
    border-color: #d73a2f;
}

.btn-orange:not(:disabled):not(.disabled):active,
.btn-orange:not(:disabled):not(.disabled).active,
.show > .btn-orange.dropdown-toggle {
    background-color: #e2542c;
    border-color: #df4e26;
}

.btn-navy:not(:disabled):not(.disabled):active,
.btn-navy:not(:disabled):not(.disabled).active,
.show > .btn-navy.dropdown-toggle {
    background-color: #134996;
    border-color: #12438a;
}

.btn-sky-blue:not(:disabled):not(.disabled):active,
.btn-sky-blue:not(:disabled):not(.disabled).active,
.show > .btn-sky-blue.dropdown-toggle {
    background-color: #1f99f2;
    border-color: #1495f1;
}

.btn-golden:not(:disabled):not(.disabled):active,
.btn-golden:not(:disabled):not(.disabled).active,
.show > .btn-golden.dropdown-toggle {
    background-color: #efbe02;
    border-color: #edb900;
}

.btn-forest:not(:disabled):not(.disabled):active,
.btn-forest:not(:disabled):not(.disabled).active,
.show > .btn-forest.dropdown-toggle {
    background-color: #417733;
    border-color: #3d6f30;
}

/* ========================================
   UTILIDADES ADICIONALES
   ======================================== */

/* Bordes con los nuevos colores */
.border-coral { border-color: #F15953 !important; }
.border-orange { border-color: #EB6E44 !important; }
.border-navy { border-color: #175BBD !important; }
.border-sky-blue { border-color: #3FA9F5 !important; }
.border-golden { border-color: #F2C525 !important; }
.border-forest { border-color: #529140 !important; }

/* Enlaces con los nuevos colores */
.text-coral:hover { color: #e04439 !important; }
.text-orange:hover { color: #e55a32 !important; }
.text-navy:hover { color: #144ea1 !important; }
.text-sky-blue:hover { color: #2a9df3 !important; }
.text-golden:hover { color: #f0c009 !important; }
.text-forest:hover { color: #468037 !important; }
</style>
@endpush
