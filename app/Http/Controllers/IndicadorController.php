<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Indicador;
use Illuminate\Http\Request;
use App\Traits\ManejaArchivos;
use Illuminate\Support\Facades\DB;
use App\Notifications\IndicadorAsignadoNotification;

class IndicadorController extends Controller
{
    use ManejaArchivos;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:indicadores.ver', ['only' => ['index', 'show']]);
        $this->middleware('can:indicadores.crear', ['only' => ['create', 'store']]);
        $this->middleware('can:indicadores.editar', ['only' => ['edit', 'update']]);
        $this->middleware('can:indicadores.eliminar', ['only' => ['destroy']]);
        $this->middleware('can:indicadores.cerrar', ['only' => ['cerrar']]);
        $this->middleware('can:indicadores.completar', ['only' => ['completar']]);
        $this->middleware('can:indicadores.reabrir', ['only' => ['reabrir']]);
    }

    public function index(Request $request)
    {
        $estado = $request->input('estado', 'abierto');

        $query = Indicador::query();

        // Filtro por estado
        if (in_array($estado, ['abierto', 'cerrado', 'completado'])) {
            $query->where('estado', $estado);
        }

        // Si no es Control de Gestión, solo ver los asignados
        if (!auth()->user()->hasRole('Control de Gestión')) {
            $query->where('cod_usuario', auth()->user()->cod_usuario);
        }

        $indicadores = $query->get();

        return view('indicadores.index', compact('indicadores', 'estado'));
    }

    public function create()
    {
        $usuarios       = Usuario::where('cod_estado_usuario', 1)->get();
        $tiposIndicador = \App\Models\TipoIndicador::all();

        return view('indicadores.create', compact('usuarios', 'tiposIndicador'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'indicador'           => 'required|string|max:4098',
            'objetivo'            => 'required|string|max:4098',
            'cod_tipo_indicador'  => 'required|exists:tipo_indicador,cod_tipo_indicador',
            'meta'                => 'required|numeric',
            'cod_usuario'         => 'required|exists:usuario,cod_usuario',
            'parametro1'          => 'nullable|string|max:1024',
            'parametro2'          => 'nullable|string|max:1024',
            'estado'              => 'nullable|string|max:255',
            'cerrado'             => 'nullable|boolean',
            'fecha_cierre'        => 'nullable|date',
            'archivos'            => 'nullable|array|max:5',
            'archivos.*'          => 'file|max:10240',
            'projections'         => 'required|array|min:1',
            'projections.*.year'  => 'required|integer|min:' . now()->year,
            'projections.*.month' => 'required|integer|between:1,12',
            'projections.*.value' => 'required|numeric|min:1',
        ], [
            'cod_usuario.required'        => 'Debe seleccionar un usuario',
            'cod_usuario.exists'          => 'El usuario asignado no es válido',
            'cod_tipo_indicador.required' => 'Debe seleccionar un tipo de indicador',
            'cod_tipo_indicador.exists'   => 'El tipo de indicador no es válido',
            'projections.required'        => 'Debe agregar al menos una proyección mensual',
            'projections.*.year.min'      => 'El año de la proyección no puede ser menor al año actual',
            'projections.*.month.between' => 'El mes de la proyección debe estar entre 1 y 12',
            'projections.*.value.min'     => 'El valor de la proyección debe ser mayor o igual a 1',
        ]);

        // Meses pasados en año actual
        foreach ($request->projections as $p) {
            if ((int)$p['year'] === now()->year && (int)$p['month'] < now()->month) {
                return back()->withErrors(['projections' => 'Existen meses anteriores al mes en curso.'])->withInput();
            }
        }

        // Duplicados
        $keys = collect($request->projections)
            ->map(fn($p) => $p['year'] . '-' . str_pad($p['month'], 2, '0', STR_PAD_LEFT));
        if ($keys->duplicates()->isNotEmpty()) {
            return back()->withErrors(['projections' => 'Hay meses duplicados en la proyección.'])->withInput();
        }

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

        DB::beginTransaction();
        try {
            $indicador = Indicador::create($data);

            if ($request->hasFile('archivos')) {
                $this->guardarArchivos($request->file('archivos'), $indicador);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return back()->withErrors([
                'general' => 'Error al crear el indicador'
            ])->withInput();
        }

        // Notificar al USUARIO ASIGNADO
        $usuarioAsignado = Usuario::find($data['cod_usuario']);
        if ($usuarioAsignado) {
            // Usa Notifiable o route() directo si prefieres
            $usuarioAsignado->notify(new IndicadorAsignadoNotification($indicador));
        }

        return redirect()
            ->route('indicadores.show', ['indicador' => $indicador->cod_indicador])
            ->with('success', 'Indicador creado exitosamente');
    }

    public function show(Indicador $indicador)
    {
        $indicador->load([
            'tipoIndicador',
            'usuarioAsignado.departamento',
            'archivos',
            'indicadoresMensuales.usuario',
        ]);

        return view('indicadores.show', compact('indicador'));
    }

    public function edit(Indicador $indicador)
    {
        $usuarios       = Usuario::where('cod_estado_usuario', 1)->get();
        $tiposIndicador = \App\Models\TipoIndicador::all();

        return view('indicadores.edit', compact('indicador', 'usuarios', 'tiposIndicador'));
    }

    public function update(Request $request, Indicador $indicador)
    {
        $data = $request->validate([
            'indicador'          => 'required|string|max:4098',
            'objetivo'           => 'required|string|max:4098',
            'cod_tipo_indicador' => 'required|exists:tipo_indicador,cod_tipo_indicador',
            'meta'               => 'required|numeric',
            'cod_usuario'        => 'required|exists:usuario,cod_usuario',
            'archivos'           => 'nullable|array|max:5',
            'archivos.*'         => 'file|max:10240',
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

        $indicador->update($data);

        // Guardar archivos nuevos
        if ($request->hasFile('archivos')) {
            $this->guardarArchivos($request->file('archivos'), $indicador);
        }

        return redirect()->route('indicadores.show', $indicador)
            ->with('success', 'Indicador actualizado exitosamente');
    }

    public function destroy(Indicador $indicador)
    {
        //$this->authorize('delete', $indicador);

        $indicador->delete();
        return redirect()->route('indicadores.index')
            ->with('success', 'Indicador eliminado exitosamente');
    }

    public function cerrar(Indicador $indicador)
    {
        //$this->authorize('cerrar', $indicador);

        $indicador->cerrar();
        return back()->with('success', 'Indicador cerrado exitosamente');
    }

    public function completar(Indicador $indicador)
    {
        //$this->authorize('completar', $indicador);

        $indicador->completar();
        return back()->with('success', 'Indicador marcado como completado');
    }

    public function reabrir(Indicador $indicador)
    {
        //$this->authorize('reabrir', $indicador);

        $indicador->reabrir();
        return back()->with('success', 'Indicador reabierto exitosamente');
    }
}
