@extends('layouts.app')

@section('title', 'Editar Indicador')
@section('subtitle', 'Formulario para editar el indicador')
@section('content_header_title', 'Editar Indicador')
@section('content_header_subtitle', 'Actualiza datos y proyección mensual')

@section('content_body')

    {{-- Éxito / Errores --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    @php
        $totalProy = (float) ($indicador->total_proyeccion ?? 0);
        $totalReal = (float) ($indicador->total_real ?? 0);
        $gap       = $totalProy - $totalReal;
    @endphp

    {{-- Filtro de año para editar la proyección del año seleccionado (server-side) --}}
    <form method="GET" action="{{ route('indicadores.edit', $indicador) }}" class="form-inline mb-3">
        <label class="mr-2">Año</label>
        <select name="anio" class="form-control mr-2">
            @for($y = now()->year; $y <= now()->year + 1; $y++)
                <option value="{{ $y }}" {{ (int)request('anio', $anio) === $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
        <button class="btn btn-outline-secondary btn-sm">Cambiar año</button>
    </form>

     {{-- Resumen del total proyectado del año seleccionado --}}
    <div class="alert alert-info">
        <strong>Total proyectado {{ $anio }}:</strong> {{ number_format($indicador->total_proyeccion ?? 0, 2) }}
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Editar Indicador: {{ $indicador->indicador }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('indicadores.update', $indicador) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="indicador" class="col-md-3 col-form-label text-md-right">Nombre del Indicador</label>
                            <div class="col-md-9">
                                <textarea id="indicador" class="form-control @error('indicador') is-invalid @enderror"
                                    name="indicador" required autofocus rows="3">{{ old('indicador', $indicador->indicador) }}</textarea>
                                @error('indicador')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="objetivo" class="col-md-3 col-form-label text-md-right">Objetivo</label>
                            <div class="col-md-9">
                                <textarea id="objetivo" class="form-control @error('objetivo') is-invalid @enderror"
                                    name="objetivo" required rows="3">{{ old('objetivo', $indicador->objetivo) }}</textarea>
                                @error('objetivo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cod_tipo_indicador" class="col-md-3 col-form-label text-md-right">Tipo de Indicador</label>
                            <div class="col-md-9">
                                <select id="cod_tipo_indicador" class="form-control @error('cod_tipo_indicador') is-invalid @enderror"
                                    name="cod_tipo_indicador" required>
                                    <option value="">Seleccione un tipo</option>
                                    @foreach($tiposIndicador as $tipo)
                                    <option value="{{ $tipo->cod_tipo_indicador }}"
                                        {{ (old('cod_tipo_indicador', $indicador->cod_tipo_indicador) == $tipo->cod_tipo_indicador) ? 'selected' : '' }}>
                                        {{ $tipo->tipo_indicador }} - {{ $tipo->descripcion }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('cod_tipo_indicador')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="meta" class="col-md-3 col-form-label text-md-right">Meta</label>
                            <div class="col-md-9">
                                <input id="meta" type="number" step="0.01" class="form-control @error('meta') is-invalid @enderror"
                                    name="meta" value="{{ old('meta', $indicador->meta) }}" required>
                                @error('meta')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cod_usuario" class="col-md-3 col-form-label text-md-right">Asignar a</label>
                            <div class="col-md-9">
                                <select id="cod_usuario" class="form-control @error('cod_usuario') is-invalid @enderror"
                                    name="cod_usuario" required>
                                    <option value="">Seleccione un usuario</option>
                                    @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->cod_usuario }}"
                                        {{ old('cod_usuario', $indicador->cod_usuario) == $usuario->cod_usuario ? 'selected' : '' }}>
                                        {{ $usuario->nombreCompleto() }} ({{ $usuario->departamento->departamento ?? 'N/A' }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('cod_usuario')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">Archivos Actuales</label>
                            <div class="col-md-9">
                                @if($indicador->archivos->count() > 0)
                                <div class="list-group">
                                    @foreach($indicador->archivos as $archivo)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="{{ route('archivos.download', $archivo) }}" target="_blank">
                                            <i class="fas fa-file mr-2"></i>{{ $archivo->nombre_original }}
                                        </a>
                                        @can('archivos.eliminar')
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirmarEliminarArchivo({{ $archivo->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endcan
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <p class="text-muted">No hay archivos adjuntos</p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="archivos" class="col-md-3 col-form-label text-md-right">Nuevos Archivos</label>
                            <div class="col-md-9">
                                <input type="file" id="archivos" class="form-control-file @error('archivos') is-invalid @enderror"
                                    name="archivos[]" multiple>
                                <small class="form-text text-muted">
                                    Puede seleccionar múltiples archivos (Máximo 10MB en total)
                                </small>
                                @error('archivos')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('archivos.*')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- =========================
                        PROYECCIÓN DE AVANCE
                        ========================== --}}
                        @php
                            use Carbon\Carbon;
                            $currentYear  = Carbon::now()->year;
                            $currentMonth = 1; //Carbon::now()->month;
                            $monthNames = [
                                1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                                5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                                9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                            ];
                            // Para el selector de año inicial:
                            $selectedYear  = (int) old('projections.0.year', $anio);
                            $startMonth    = $selectedYear === $currentYear ? $currentMonth : 1;
                            $selectedMonth = (int) old('projections.0.month', $startMonth);
                            $selectedValue = old('projections.0.value', 0);

                            // Dataset para precargar filas existentes del año seleccionado
                            $existingProjections = $indicador->proyecciones
                                ->map(fn($p)=>['year'=>$p->anio,'month'=>$p->mes,'value'=>$p->valor])
                                ->values();
                        @endphp
                        <div class="form-group">
                            <div class="d-flex align-items-center mb-2">
                                <h5 class="mb-0">Proyección de Avance ({{ $anio }})</h5>
                                <span class="badge badge-info ml-2">Editar</span>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="proj-year">Año</label>
                                            <select id="proj-year" class="form-control">
                                                <option value="{{ $currentYear }}" {{ $selectedYear === $currentYear ? 'selected' : '' }}>
                                                    {{ $currentYear }}
                                                </option>
                                                <option value="{{ $currentYear + 1 }}" {{ $selectedYear === $currentYear + 1 ? 'selected' : '' }}>
                                                    {{ $currentYear + 1 }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-5">
                                            <label for="proj-month">Mes</label>
                                            <select id="proj-month" class="form-control" data-current-year="{{ $currentYear }}" data-current-month="{{ $currentMonth }}">
                                                @foreach(range($startMonth, 12) as $m)
                                                <option value="{{ $m }}" {{ $selectedMonth === $m ? 'selected' : '' }}>
                                                    {{ $monthNames[$m] }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <small class="form-text text-muted">
                                                Si eliges {{ $currentYear }}, no se permiten meses anteriores a {{ $monthNames[$currentMonth] }}.
                                            </small>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="proj-value">Proyección del Mes</label>
                                            <input id="proj-value" type="number" step="0.01" min="0" class="form-control" placeholder="0.00" value="{{ $selectedValue }}">
                                        </div>

                                        <div class="form-group col-md-1 d-flex align-items-end">
                                            <button type="button" id="btn-add-projection" class="btn btn-outline-primary btn-block">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered mb-2" id="projections-table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 20%">Año</th>
                                                    <th style="width: 35%">Mes</th>
                                                    <th style="width: 30%">Proyección</th>
                                                    <th style="width: 15%">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- Filas se precargarán con las proyecciones existentes y podrás agregar nuevas --}}
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="2" class="text-right">Total Proyectado:</th>
                                                    <th><span id="proj-total">0.00</span></th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    @error('projections')<div class="text-danger mt-2">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                        {{-- ========================= --}}

                        <div class="form-group row mb-0">
                            <div class="col-md-9 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Actualizar Indicador
                                </button>
                                <a href="{{ route('indicadores.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </div>
                        </div>
                        {{-- Mantener el año al enviar --}}
                        <input type="hidden" name="anio" value="{{ $anio }}">
                    </form>
                </div>
            </div>
            {{-- Meses en español para JS sin duplicar strings --}}
            <script type="application/json" id="month-names-json">
                {!! json_encode(array_values($monthNames), JSON_UNESCAPED_UNICODE) !!}
            </script>

            {{-- Proyecciones existentes del año seleccionado para precarga --}}
            <script type="application/json" id="existing-projections-json">
                {!! $existingProjections->toJson(JSON_UNESCAPED_UNICODE) !!}
            </script>
        </div>
    </div>

    <form id="delete-file-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@stop

@push('js')
    <script>
        function confirmarEliminarArchivo(archivoId) {
            if (confirm('¿Está seguro que desea eliminar este archivo?')) {
                const form = document.getElementById('delete-file-form');
                form.action = `/archivos/${archivoId}`;
                form.submit();
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // --- Referencias UI ---
            const projYear   = document.getElementById('proj-year');
            const projMonth  = document.getElementById('proj-month');
            const projValue  = document.getElementById('proj-value');
            const tableBody  = document.querySelector('#projections-table tbody');
            const totalSpan  = document.getElementById('proj-total');

            // --- Datos desde Blade ---
            const monthNames = JSON.parse(document.getElementById('month-names-json').textContent);
            const existing   = JSON.parse(document.getElementById('existing-projections-json').textContent || '[]');
            const currentYear  = parseInt(projMonth.dataset.currentYear, 10);
            const currentMonth = parseInt(projMonth.dataset.currentMonth, 10);

            // Estado para evitar duplicados (YYYY-MM)
            const chosen = new Set();

            function pad2(n){ return String(n).padStart(2, '0'); }
            function keyOf(y, m){ return `${y}-${pad2(m)}`; }

            function rebuildMonthOptionsForYear(targetYear) {
                while (projMonth.firstChild) projMonth.removeChild(projMonth.firstChild);
                const start = (parseInt(targetYear,10) === currentYear) ? currentMonth : 1;
                for (let m = start; m <= 12; m++) {
                    const opt = document.createElement('option');
                    opt.value = m;
                    opt.textContent = monthNames[m-1];
                    projMonth.appendChild(opt);
                }
            }

            function recalcTotal() {
                let sum = 0;
                tableBody.querySelectorAll('input[name$="[value]"]').forEach(inp => {
                    const v = parseFloat(inp.value);
                    if (!isNaN(v)) sum += v;
                });
                totalSpan.textContent = sum.toFixed(2);
            }

            function reindexRows() {
                Array.from(tableBody.querySelectorAll('tr')).forEach((row, i) => {
                    row.querySelectorAll('input[name]').forEach(inp => {
                        inp.name = inp.name.replace(/projections\[\d+\]/, `projections[${i}]`);
                    });
                });
            }

            function addProjectionRow(y, m, v) {
                const key = keyOf(y, m);
                if (chosen.has(key)) {
                    alert(`Ya agregaste ${monthNames[m-1]} de ${y}.`);
                    return;
                }
                const idx = tableBody.querySelectorAll('tr').length;
                const tr  = document.createElement('tr');
                tr.dataset.key = key;
                tr.innerHTML = `
                    <td class="align-middle">
                        <input type="hidden" name="projections[${idx}][year]" value="${y}">
                        ${y}
                    </td>
                    <td class="align-middle">
                        <input type="hidden" name="projections[${idx}][month]" value="${m}">
                        ${monthNames[m-1]}
                    </td>
                    <td>
                        <input type="number" step="0.01" min="0" name="projections[${idx}][value]"
                        value="${(parseFloat(v)||0).toFixed(2)}" class="form-control form-control-sm proj-value">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tableBody.appendChild(tr);
                chosen.add(key);
                recalcTotal();
            }

            // Eventos
            projYear.addEventListener('change', function () {
                rebuildMonthOptionsForYear(this.value);
            });

            document.getElementById('btn-add-projection').addEventListener('click', function () {
                const y = parseInt(projYear.value, 10);
                const m = parseInt(projMonth.value, 10);
                const val = parseFloat(projValue.value);

                if (isNaN(val) || val < 0) {
                    alert('Ingresa un valor de proyección válido (número ≥ 0).');
                    return;
                }
                if (y === currentYear && m < currentMonth) {
                    alert('No se permiten meses anteriores al mes en curso.');
                    return;
                }
                addProjectionRow(y, m, val);
                projValue.value = '';
            });

            tableBody.addEventListener('input', function (e) {
                if (e.target.classList.contains('proj-value')) recalcTotal();
            });

            tableBody.addEventListener('click', function (e) {
                if (e.target.closest('.btn-remove')) {
                    const tr = e.target.closest('tr');
                    chosen.delete(tr.dataset.key);
                    tr.remove();
                    reindexRows();
                    recalcTotal();
                }
            });

            // Inicialización
            rebuildMonthOptionsForYear(projYear.value);

            // Precargar filas existentes del año seleccionado (si hay)
            if (Array.isArray(existing) && existing.length) {
                tableBody.innerHTML = '';
                chosen.clear();
                existing.forEach(p => addProjectionRow(parseInt(p.year,10), parseInt(p.month,10), parseFloat(p.value)));
            } else {
                // Si no hay registros, agrega una fila inicial con el mes seleccionado
                addProjectionRow(parseInt(projYear.value,10), parseInt(projMonth.value,10), parseFloat('0'));
            }
        });
    </script>
@endpush
