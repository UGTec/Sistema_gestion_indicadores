<?php

namespace App\Http\Controllers;

use App\Models\Indicador;
use App\Models\ProcesoEstrategico;
use App\Models\Condicional;
use Illuminate\Http\Request;
use App\Models\IndicadorMensual;
use App\Traits\ManejaArchivos;
use Illuminate\Support\Facades\Storage;


class IndicadorMensualController extends Controller
{
    use ManejaArchivos;

    public function create(Indicador $indicador)
    {
        $this->authorize('create', [IndicadorMensual::class, $indicador]);

        $currentMonth = now()->month;
        $previousMonth = $currentMonth === 1 ? 12 : $currentMonth - 1;

        // Verificar si el mes anterior tiene registro mensual para este indicador y año actual
        $anioActual = now()->year;
        $existsPrevMonth = $indicador->indicadoresMensuales()
            ->where('mes', $previousMonth)
            ->where('año', $anioActual)
            ->exists();

        return view('indicadores-mensuales.create', compact('indicador', 'currentMonth', 'previousMonth', 'existsPrevMonth'));
    }

    public function store(Request $request, Indicador $indicador)
    {
        $this->authorize('create', [IndicadorMensual::class, $indicador]);

        $data = $request->validate(
            [
                'mes'           => 'required|numeric|between:1,12',
                'año'           => 'required|numeric|min:' . date('Y') . '|max:' . (date('Y') + 1),
                'numerador'     => 'required|numeric',
                'denominador'   => 'required|numeric',
                'observaciones' => 'nullable|string|max:500',
                'archivos'      => 'nullable|array|max:5',
                'archivos.*'    => 'file|max:10240',
            ],
            [
                'año.min' => 'El año no puede ser menor al año en curso',
            ]
        );

        // Tamaño total de adjuntos (<= 10MB)
        $totalSize = 0;
        if ($request->hasFile('archivos')) {
            $totalSize = array_reduce($request->file('archivos'), fn ($sum, $f) => $sum + $f->getSize(), 0);
            if ($totalSize > 10 * 1024 * 1024) {
                return back()->withErrors([
                    'archivos' => 'El tamaño total no puede exceder 10MB'
                ])->withInput();
            }
        }

        $data['resultado']           = ($data['numerador'] / $data['denominador']) * 100;
        $data['cod_usuario']         = auth()->user()->cod_usuario;
        $data['fecha_actualizacion'] = now();

        $indicadorMensual = $indicador->indicadoresMensuales()->create($data);

        if ($request->hasFile('archivos')) {
            $this->guardarArchivos($request->file('archivos'), $indicadorMensual);
        }

        return redirect()->route('indicadores.show', $indicador)
            ->with('success', 'Registro mensual creado exitosamente');
    }

    public function edit(Indicador $indicador, IndicadorMensual $mensual)
    {
        $this->authorize('update', $mensual);

        return view('indicadores-mensuales.edit', compact('indicador', 'mensual'));
    }

    public function update(Request $request, Indicador $indicador, IndicadorMensual $mensual)
    {
        $this->authorize('update', $mensual);

        $data = $request->validate([
            'numerador'     => 'required|numeric',
            'denominador'   => 'required|numeric',
            'observaciones' => 'nullable|string|max:500',
            'archivos'      => 'nullable|array|max:5',
            'archivos.*'    => 'file|max:10240',
        ]);

        // Validar tamaño total
        if ($request->hasFile('archivos')) {
            $totalSize = array_reduce($request->file('archivos'), function ($sum, $file) {
                return $sum + $file->getSize();
            }, 0);

            if ($totalSize > 10 * 1024 * 1024) { // 10MB
                return back()->withErrors(['archivos' => 'El tamaño total de los archivos no puede exceder los 10MB']);
            }
        }

        // Guardar archivos nuevos
        if ($request->hasFile('archivos')) {
            $this->guardarArchivos($request->file('archivos'), $mensual);
        }

        $data['resultado']                = ($data['numerador'] / $data['denominador']) * 100;
        $data['cod_usuario_modificacion'] = auth()->user()->cod_usuario;
        $data['fecha_actualizacion']      = now();

        $mensual->update($data);

        return redirect()->route('indicadores.show', $indicador)
            ->with('success', 'Registro mensual actualizado exitosamente');
    }

    public function revisar(Indicador $indicador, IndicadorMensual $mensual)
    {
        $this->authorize('revisar', $mensual);
        $procesos = ProcesoEstrategico::all();
        $condiciones = Condicional::all();

        return view('indicadores-mensuales.revisar', compact('indicador', 'mensual', 'procesos', 'condiciones'));
    }

    public function updateRevisar(Request $request, Indicador $indicador, IndicadorMensual $mensual)
    {
        // 1. Autorización
        // Verifica que el usuario tiene permiso para 'revisar' este registro mensual
        $this->authorize('revisar', $mensual);

        // 2. Validación de Datos
        $data = $request->validate([
            // Campos existentes y el nuevo 'proceso'
            'cod_proceso_estrategico'      => 'required|numeric|exists:proceso_estrategico,id',

            // --- Condicionales (Selects) ---
            // Deben ser obligatorios y el valor debe existir en la tabla 'condicional'
            'condicional_oportunidad'      => 'required|numeric|exists:condicional,cod_condicional',
            'condicional_completitud'      => 'required|numeric|exists:condicional,cod_condicional',
            'condicional_progreso'         => 'required|numeric|exists:condicional,cod_condicional',
            'condicional_riesgo'           => 'required|numeric|exists:condicional,cod_condicional',

            // --- Descripciones (Inputs de Texto) ---
            // Se asumen opcionales (nullable) y con un límite de 500 caracteres
            'descripcion_oportunidad'      => 'nullable|string|max:500',
            'descripcion_completitud'      => 'nullable|string|max:500',
            'descripcion_progreso'         => 'nullable|string|max:500',
            'descripcion_riesgo'           => 'nullable|string|max:500',

            // --- Gestión (Input de Texto General) ---
            'gestiones'                    => 'nullable|string|max:500',
        ]);

        // 3. Actualizar el Registro
        // Los datos validados ($data) se pasan directamente al método update() del modelo.
        // Esto funciona porque todas las claves de $data están en el array $fillable del modelo IndicadorMensual.
        $mensual->update($data);

        // 4. Redirección
        return redirect()->route('indicadores.show', $indicador)
            ->with('success', 'Revisión mensual realizada exitosamente');
    }

    public function destroy(Indicador $indicador, IndicadorMensual $mensual)
    {
        $this->authorize('delete', $mensual);

        // Eliminar archivos asociados
        foreach ($mensual->archivos as $archivo) {
            Storage::delete($archivo->ruta); // Elimina archivo físico
            $archivo->delete();              // Elimina registro en BD
        }

        $mensual->delete();

        return redirect()->route('indicadores.show', $indicador)
            ->with('success', 'Registro mensual eliminado exitosamente');
    }
}
