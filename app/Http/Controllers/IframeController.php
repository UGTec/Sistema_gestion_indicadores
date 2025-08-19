<?php

namespace App\Http\Controllers;

use App\Models\Iframe;
<<<<<<< HEAD
use Illuminate\Http\Request;
use Illuminate\View\View;
=======
use Illuminate\View\View;
use Illuminate\Http\Request;
>>>>>>> aa75e952fac1efc1436eef8f1edcee7dd9adb13a
use Illuminate\Http\RedirectResponse;

class IframeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $iframes = Iframe::get();
        return view('iframes.index', compact('iframes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('iframes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
<<<<<<< HEAD
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:2048',
            'description' => 'nullable|string',
            'width' => ['required', 'string', 'regex:/^(auto|inherit|\d+(%|px|em|rem|vh|vw)|\d+)$/'],
            'height' => ['required', 'string', 'regex:/^(auto|inherit|\d+(%|px|em|rem|vh|vw)|\d+)$/'],
            'is_active' => 'boolean'
        ], [
            'width.regex' => 'El ancho debe ser un número con unidad (px, %, em, rem, vh, vw) o auto/inherit',
=======
            'name'        => 'required|string|max:255',
            'url'         => 'required|url|max:2048',
            'description' => 'nullable|string',
            'width'       => ['required', 'string', 'regex:/^(auto|inherit|\d+(%|px|em|rem|vh|vw)|\d+)$/'],
            'height'      => ['required', 'string', 'regex:/^(auto|inherit|\d+(%|px|em|rem|vh|vw)|\d+)$/'],
            'is_active'   => 'boolean'
        ], [
            'width.regex'  => 'El ancho debe ser un número con unidad (px, %, em, rem, vh, vw) o auto/inherit',
>>>>>>> aa75e952fac1efc1436eef8f1edcee7dd9adb13a
            'height.regex' => 'La altura debe ser un número con unidad (px, %, em, rem, vh, vw) o auto/inherit'
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Mensaje de advertencia si se está activando un iframe
        if ($validated['is_active']) {
            $activeCount = Iframe::where('is_active', true)->count();
            if ($activeCount > 0) {
                session()->flash('warning', 'Se desactivó el iframe activo anterior para activar este nuevo iframe.');
            }
        }

        Iframe::create($validated);

        return redirect()->route('iframes.index')
            ->with('success', 'Iframe creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Iframe $iframe): View
    {
        return view('iframes.show', compact('iframe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Iframe $iframe): View
    {
        return view('iframes.edit', compact('iframe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Iframe $iframe): RedirectResponse
    {
        $validated = $request->validate([
<<<<<<< HEAD
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:2048',
            'description' => 'nullable|string',
            'width' => ['required', 'string', 'regex:/^(auto|inherit|\d+(%|px|em|rem|vh|vw)|\d+)$/'],
            'height' => ['required', 'string', 'regex:/^(auto|inherit|\d+(%|px|em|rem|vh|vw)|\d+)$/'],
            'is_active' => 'boolean'
        ], [
            'width.regex' => 'El ancho debe ser un número con unidad (px, %, em, rem, vh, vw) o auto/inherit',
=======
            'name'        => 'required|string|max:255',
            'url'         => 'required|url|max:2048',
            'description' => 'nullable|string',
            'width'       => ['required', 'string', 'regex:/^(auto|inherit|\d+(%|px|em|rem|vh|vw)|\d+)$/'],
            'height'      => ['required', 'string', 'regex:/^(auto|inherit|\d+(%|px|em|rem|vh|vw)|\d+)$/'],
            'is_active'   => 'boolean'
        ], [
            'width.regex'  => 'El ancho debe ser un número con unidad (px, %, em, rem, vh, vw) o auto/inherit',
>>>>>>> aa75e952fac1efc1436eef8f1edcee7dd9adb13a
            'height.regex' => 'La altura debe ser un número con unidad (px, %, em, rem, vh, vw) o auto/inherit'
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Mensaje de advertencia si se está activando un iframe
        if ($validated['is_active'] && !$iframe->is_active) {
            $activeCount = Iframe::where('is_active', true)->where('id', '!=', $iframe->id)->count();
            if ($activeCount > 0) {
                session()->flash('warning', 'Se desactivó el iframe activo anterior para activar este iframe.');
            }
        }

        $iframe->update($validated);

        return redirect()->route('iframes.index')
            ->with('success', 'Iframe actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Iframe $iframe): RedirectResponse
    {
        $iframe->delete();

        return redirect()->route('iframes.index')
            ->with('success', 'Iframe eliminado exitosamente.');
    }

    /**
     * Display the iframe content
     */
    public function display(Iframe $iframe = null): View
    {
        // Si no se especifica iframe, buscar el activo
        if (!$iframe) {
            $iframe = Iframe::active()->first();
            if (!$iframe) {
                abort(404, 'No hay ningún iframe activo');
            }
        }

        if (!$iframe->is_active) {
            abort(404, 'Este iframe no está activo');
        }

        return view('iframes.display', compact('iframe'));
    }

    /**
     * Obtener el iframe activo actual
     */
    public function getActive()
    {
        $iframe = Iframe::active()->first();

        if (!$iframe) {
            return response()->json(['message' => 'No hay iframe activo'], 404);
        }

        return response()->json([
<<<<<<< HEAD
            'id' => $iframe->id,
            'name' => $iframe->name,
            'url' => $iframe->url,
            'width' => $iframe->width,
            'height' => $iframe->height,
=======
            'id'          => $iframe->id,
            'name'        => $iframe->name,
            'url'         => $iframe->url,
            'width'       => $iframe->width,
            'height'      => $iframe->height,
>>>>>>> aa75e952fac1efc1436eef8f1edcee7dd9adb13a
            'description' => $iframe->description
        ]);
    }
}
