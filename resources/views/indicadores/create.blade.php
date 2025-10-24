@extends('layouts.app')

@section('title', 'Crear Indicador')
@section('subtitle', 'Formulario para crear un nuevo indicador')
@section('content_header_title', 'Crear Nuevo Indicador')
@section('content_header_subtitle', 'Formulario para crear un nuevo indicador')

@section('content_body')

    {{-- Display success message if available --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Crear Nuevo Indicador</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('indicadores.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="indicador" class="col-md-3 col-form-label text-md-right">Nombre del Indicador</label>
                            <div class="col-md-9">
                                <textarea id="indicador" class="form-control @error('indicador') is-invalid @enderror"
                                    name="indicador"  autofocus rows="3">{{ old('indicador') }}</textarea>
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
                                    name="objetivo"  rows="3">{{ old('objetivo') }}</textarea>
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
                                    name="cod_tipo_indicador" >
                                    <option value="">Seleccione un tipo</option>
                                    @foreach($tiposIndicador as $tipo)
                                    <option value="{{ $tipo->cod_tipo_indicador }}" {{ old('cod_tipo_indicador') == $tipo->cod_tipo_indicador ? 'selected' : '' }}>
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
                            <label for="parametro1" class="col-md-3 col-form-label text-md-right">Numerador</label>
                            <div class="col-md-9">
                                <textarea id="parametro1" class="form-control @error('parametro1') is-invalid @enderror"
                                    name="parametro1" rows="2">{{ old('parametro1') }}</textarea>
                                @error('parametro1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="parametro2" class="col-md-3 col-form-label text-md-right">Denominador</label>
                            <div class="col-md-9">
                                <textarea id="parametro2" class="form-control @error('parametro2') is-invalid @enderror"
                                    name="parametro2" rows="2">{{ old('parametro2') }}</textarea>
                                @error('parametro2')
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
                                    name="meta" value="{{ old('meta') }}" >
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
                                    name="cod_usuario" >
                                    <option value="">Seleccione un usuario</option>
                                    @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->cod_usuario }}" {{ old('cod_usuario') == $usuario->cod_usuario ? 'selected' : '' }}>
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
                            <label for="invertida_check" class="col-md-3 col-form-label text-md-right">Invertida</label>
                            <div class="col-md-9 d-flex align-items-center"> <div class="form-check">
                                    {{-- <input class="form-check-input" type="checkbox" value="1" id="invertida_check" name="invertida" {{ old('invertida') ? 'checked' : '' }}> --}}
                                    <input class="form-check-input" type="checkbox" value="1" id="invertida_check" name="invertida">
                                    <label class="form-check-label" for="invertida_check">

                                    </label>
                                </div>
                                @error('invertida')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="archivos" class="col-md-3 col-form-label text-md-right">Archivos Adjuntos</label>
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
                        <hr>
                        <div class="form-group">
                            @php
                                use Carbon\Carbon;
                                $currentYear  = Carbon::now()->year;
                                $currentMonth = Carbon::now()->month;
                                $monthNames   = [
                                    1 => 'Enero',
                                    2 => 'Febrero',
                                    3 => 'Marzo',
                                    4 => 'Abril',
                                    5 => 'Mayo',
                                    6 => 'Junio',
                                    7 => 'Julio',
                                    8 => 'Agosto',
                                    9 => 'Septiembre',
                                    10 => 'Octubre',
                                    11 => 'Noviembre',
                                    12 => 'Diciembre'
                                ];

                                // Año y mes iniciales (primer render desde servidor)
                                $selectedYear  = (int) old('projections.0.year', $currentYear);
                                //$startMonth    = $selectedYear === $currentYear ? $currentMonth : 1;
                                $startMonth    = 1;
                                $selectedMonth = (int) old('projections.0.month', $startMonth);
                                $selectedValue = old('projections.0.value', 0);
                            @endphp
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Proyección de Avance</h5>
                                </div>
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
                                                {{-- Opciones generadas por Blade para el año actual (desde mes actual) --}}
                                                @foreach(range($startMonth, 12) as $m)
                                                <option value="{{ $m }}" {{ $selectedMonth === $m ? 'selected' : '' }}>
                                                    {{ $monthNames[$m] }}
                                                </option>
                                                @endforeach
                                            </select>
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
                                                {{-- Fila inicial se agrega vía JS al cargar (con los valores seleccionados arriba) --}}
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

                                    {{-- Estos nombres permiten enviar al backend como array: projections[i][year|month|value] --}}
                                    @error('projections')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-9 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Crear Indicador
                                </button>
                                <a href="{{ route('indicadores.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

@push('js')
    <script type="application/json" id="month-names-json">
        {!! json_encode(array_values($monthNames), JSON_UNESCAPED_UNICODE) !!}
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Validación de tamaño máximo de archivos (10MB)
            const fileInput = document.getElementById('archivos');
            const maxSize = 10 * 1024 * 1024; // 10MB en bytes

            fileInput.addEventListener('change', function() {
                const files = this.files;
                let totalSize = 0;

                for (let i = 0; i < files.length; i++) {
                    totalSize += files[i].size;
                }

                if (totalSize > maxSize) {
                    alert('El tamaño total de los archivos no puede exceder los 10MB');
                    this.value = ''; // Limpiar la selección
                }
            });
            // --- Referencias UI ---
            const projYear   = document.getElementById('proj-year');
            const projMonth  = document.getElementById('proj-month');
            const projValue  = document.getElementById('proj-value');
            const tableBody  = document.querySelector('#projections-table tbody');
            const totalSpan  = document.getElementById('proj-total');

            // --- Datos de entorno desde Blade ---
            const monthNames = JSON.parse(document.getElementById('month-names-json').textContent);
            const currentYear  = parseInt(projMonth.dataset.currentYear, 10);
            const currentMonth = parseInt(projMonth.dataset.currentMonth, 10);

            // --- Estado para evitar meses duplicados (clave "YYYY-MM") ---
            const chosen = new Set();

            function pad2(n){
                return String(n).padStart(2, '0');
            }
            function keyOf(y, m){
                return `${y}-${pad2(m)}`;
            }

            function rebuildMonthOptionsForYear(targetYear) {
                // Limpia opciones actuales
                while (projMonth.firstChild) projMonth.removeChild(projMonth.firstChild);

                // Si es año actual: desde currentMonth..12; si no, 1..12
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
            // --- Eventos ---
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
                // Si es año actual, bloquear meses pasados por si el select fue manipulado
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
            // --- Inicialización ---
            // Asegura que el combo de meses inicial refleje correctamente el año ya seleccionado (por Blade)
            rebuildMonthOptionsForYear(projYear.value);
            // Selecciona el mes que Blade dejó marcado (si existe)
            const initialMonth = {{ (int) $selectedMonth }};
            if (projMonth.querySelector(`option[value="${initialMonth}"]`)) {
                projMonth.value = String(initialMonth);
            }

            // Agrega la primera fila con los valores actuales del selector
            addProjectionRow(
                parseInt(projYear.value,10),
                parseInt(projMonth.value,10),
                parseFloat('{{ (float) $selectedValue }}')
            );
        });
    </script>
@endpush
