<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Indicador;
use Illuminate\Http\Request;
use App\Traits\ManejaArchivos;
use Illuminate\Support\Facades\DB;
use App\Models\IndicadorProyeccionMensual;
use App\Notifications\IndicadorAsignadoNotification;
use Illuminate\Support\Facades\Storage;

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
        $this->middleware('can:indicadores.restaurar', ['only' => ['restaurar']]);
    }

    public function index(Request $request)
    {
        $estado = $request->input('estado', 'abierto');
        $anio   = (int) $request->input('anio', now()->year);

        $query = Indicador::query()
            ->with(['tipoIndicador', 'usuario'])
            ->withMax(
                [
                    //'proyecciones as total_proyeccion' => fn ($q) => $q->where('anio', $anio)
                    'proyecciones as total_proyeccion' => fn ($q) => $q->where('anio', $anio)->orderByDesc('valor')
                ],
                'valor'
            );

        // Filtro por estado
        if (in_array($estado, ['abierto', 'cerrado', 'completado'])) {
            $query->where('estado', $estado);
        }

        // Si no es Control de Gestión, solo ver los asignados
        if (!auth()->user()->hasRole('Control de Gestión')) {
            $query->where('cod_usuario', auth()->user()->cod_usuario);
        }

        $indicadores = $query->get();

        //cargar eliminados
        $puedeVerEliminados    = auth()->user()->hasRole('Control de Gestión') || auth()->user()->can('indicadores.restaurar');
        $indicadoresEliminados = collect();
        $countEliminados       = 0;

        if ($puedeVerEliminados) {
            $indicadoresEliminados = Indicador::onlyTrashed()
                ->with(['tipoIndicador', 'usuario'])
                ->orderByDesc('deleted_at')
                ->get();
            $countEliminados = $indicadoresEliminados->count();
        }

        return view('indicadores.index', compact(
            'indicadores',
            'estado',
            'anio',
            'puedeVerEliminados',
            'indicadoresEliminados',
            'countEliminados'
        ));
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
            'projections'         => 'required|array|min:0',
            'projections.*.year'  => 'required|integer|min:' . now()->year,
            'projections.*.month' => 'required|integer|between:1,12',
            'projections.*.value' => 'required|numeric|min:0',
        ], [
            'cod_usuario.required'        => 'Debe seleccionar un usuario',
            'cod_usuario.exists'          => 'El usuario asignado no es válido',
            'cod_tipo_indicador.required' => 'Debe seleccionar un tipo de indicador',
            'cod_tipo_indicador.exists'   => 'El tipo de indicador no es válido',
            'projections.required'        => 'Debe agregar al menos una proyección mensual',
            'projections.*.year.min'      => 'El año de la proyección no puede ser menor al año actual',
            'projections.*.month.between' => 'El mes de la proyección debe estar entre 1 y 12',
            'projections.*.value.min'     => 'El valor de la proyección debe ser mayor o igual a 0',
        ]);

        // Meses pasados en año actual
        foreach ($request->projections as $p) {
            //if ((int)$p['year'] === now()->year && (int)$p['month'] < now()->month) {
            //    return back()->withErrors(['projections' => 'Existen meses anteriores al mes en curso.'])->withInput();
            //}
        }

        // Duplicados
        $keys = collect($request->projections)
            ->map(fn ($p) => $p['year'] . '-' . str_pad($p['month'], 2, '0', STR_PAD_LEFT));
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

            $rows   = [];
            $userId = auth()->check() ? auth()->user()->cod_usuario ?? null : null;

            foreach ($request->projections as $p) {
                $rows [] = [
                    'cod_indicador' => $indicador->cod_indicador,
                    'anio'          => (int) $p['year'],
                    'mes'           => (int) $p['month'],
                    'valor'         => (float) $p['value'],
                    'cod_usuario'   => $userId,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            }

            IndicadorProyeccionMensual::insert($rows);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return back()->withErrors([
                'general' => 'Error al crear el indicador' . $e->getMessage()
            ])->withInput();
        }

        // Notificar al USUARIO ASIGNADO
        $usuarioAsignado = Usuario::find($data['cod_usuario']);
        //if ($usuarioAsignado) {
            // Usa Notifiable o route() directo si prefieres
           // $usuarioAsignado->notify(new IndicadorAsignadoNotification($indicador));
       // }

        return redirect()
            ->route('indicadores.show', ['indicador' => $indicador->cod_indicador])
            ->with('success', 'Indicador creado exitosamente');
    }

    public function show(Request $request, Indicador $indicador)
    {
        $anio = (int) $request->input('anio', now()->year);

        // cargar realciones + sumas : proyeccion y real (si tiene registrosMensuales)
        $indicador->load([
            'tipoIndicador',
            'usuarioAsignado.departamento',
            'archivos',
            'indicadoresMensuales.usuario',
            'proyecciones'       => fn ($q) => $q->where('anio', $anio)->orderBy('mes'),
            'registrosMensuales' => fn ($q) => $q->where('año', $anio)->orderBy('mes'),
        ]);

        $indicador->loadMax(['proyecciones as total_proyeccion' => fn ($q) => $q->where('anio', $anio)], 'valor');
        $indicador->loadMax(['registrosMensuales as total_real' => fn ($q) => $q->where('año', $anio)], 'resultado');

        return view('indicadores.show', compact('indicador', 'anio'));
    }

    public function edit(Request $request, Indicador $indicador)
    {
        $anio = (int) $request->input('anio', now()->year);

        $indicador->load([
            'tipoIndicador',
            'usuario',
            'proyecciones' => fn ($q) => $q->where('anio', $anio)->orderBy('mes'),
        ]);

        $indicador->loadMax([
             'proyecciones as total_proyeccion' => fn ($q) => $q->where('anio', $anio)
             ], 'valor');

        $usuarios       = Usuario::where('cod_estado_usuario', 1)->get();
        $tiposIndicador = \App\Models\TipoIndicador::all();

        return view('indicadores.edit', compact('indicador', 'usuarios', 'tiposIndicador', 'anio'));
    }

    public function update(Request $request, Indicador $indicador)
    {
        $data = $request->validate(
            [
                'indicador'           => 'required|string|max:4098',
                'objetivo'            => 'required|string|max:4098',
                'cod_tipo_indicador'  => 'required|exists:tipo_indicador,cod_tipo_indicador',
                'meta'                => 'required|numeric',
                'cod_usuario'         => 'required|exists:usuario,cod_usuario',
                'parametro1'          => 'required|string|max:1024',
                'parametro2'          => 'required|string|max:1024',
                'archivos'            => 'nullable|array|max:5',
                'archivos.*'          => 'file|max:10240',
                'projections'         => 'required|array|min:1',
                'projections.*.year'  => 'required|integer|min:' . now()->year,
                'projections.*.month' => 'required|integer|between:1,12',
                'projections.*.value' => 'required|numeric|min:0',
            ],
            [
                'projections.required' => 'Debe agregar al menos una proyección mensual'
            ]
        );

        // Validar tamaño total
        if ($request->hasFile('archivos')) {
            $totalSize = array_reduce($request->file('archivos'), function ($sum, $file) {
                return $sum + $file->getSize();
            }, 0);

            if ($totalSize > 10 * 1024 * 1024) { // 10MB
                return back()->withErrors(['archivos' => 'El tamaño total de los archivos no puede exceder los 10MB']);
            }
        }

        //foreach ($request->projections as $p) {
            //if ((int)$p['year'] === now()->year && (int)$p['month'] < now()->month) {
            //    return back()
            //        ->withErrors(['projections' => 'Existen meses anteriores al mes en curso.'])
            //        ->withInput();
            //}
        //}

        $dupes = collect($request->projections)
            ->map(fn ($p) => $p['year'] . '-' . str_pad($p['month'], 2, '0', STR_PAD_LEFT))
            ->duplicates();
        if ($dupes->isNotEmpty()) {
            return back()
                ->withErrors(['projections' => 'Hay meses duplicados en la proyección.'])
                ->withInput();
        }

        DB::transaction(function () use ($request, $indicador, $data) {
            $indicador->update([
                'indicador'          => $data['indicador'],
                'objetivo'           => $data['objetivo'],
                'cod_tipo_indicador' => $data['cod_tipo_indicador'],
                'meta'               => $data['meta'],
                'cod_usuario'        => $data['cod_usuario'],
                'parametro1'         => $data['parametro1'],
                'parametro2'         => $data['parametro2'],
            ]);

            $userId = auth()->check() ? auth()->user()->cod_usuario ?? null : null;

            $payload = collect($request->projections)->map(function ($p) use ($indicador, $userId) {
                return [
                    'cod_indicador' => $indicador->cod_indicador,
                    'anio'          => (int) $p['year'],
                    'mes'           => (int) $p['month'],
                    'valor'         => (float) $p['value'],
                    'cod_usuario'   => $userId,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            })->all();

            // upsert por clave compuesta
            IndicadorProyeccionMensual::upsert(
                $payload,
                ['cod_indicador', 'anio', 'mes'],
                ['valor', 'cod_usuario', 'updated_at']
            );

            // (Opcional) eliminar lo que ya no venga en el request
            $keepKeys = collect($payload)->map(fn ($r) => $r['anio'] . '-' . $r['mes'])->all();
            $indicador->proyecciones()
                ->whereNotIn(DB::raw("CONCAT(anio,'-',mes)"), $keepKeys)
                ->delete();

            // Guardar archivos nuevos
            if ($request->hasFile('archivos')) {
                $this->guardarArchivos($request->file('archivos'), $indicador);
            }
        });

        //$indicador->update($data);

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

    public function restaurar($indicador)
    {

        if (!auth()->user()->hasRole('Control de Gestión') && !auth()->user()->can('indicadores.restaurar')) {
            abort(403);
        }

        $model = Indicador::onlyTrashed()->findOrFail($indicador);
        $model->restore();

        return redirect()
            ->route('indicadores.index')
            ->with('success', 'Indicador restaurado correctamente.');
    }

    // (Opcional) eliminación definitiva:
    public function forceDelete(Indicador $indicador)
    {
        $this->authorize('forceDelete', Indicador::class); // o usa middleware de permiso
        // Eliminar archivos asociados
        foreach ($indicador->archivos as $archivo) {
            Storage::delete($archivo->ruta); // Elimina archivo físico
            $archivo->delete();              // Elimina registro en BD
        }
        $indicador = Indicador::onlyTrashed()->findOrFail($indicador);
        $indicador->forceDelete();

        return back()->with('success', 'Indicador eliminado definitivamente.');
    }
}
