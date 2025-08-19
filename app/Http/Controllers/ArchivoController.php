<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller
{
    public function download(Archivo $archivo)
    {
        if (!Storage::exists($archivo->ruta)) {
            abort(404);
        }

        return Storage::download($archivo->ruta, $archivo->nombre_original);
    }

    public function destroy(Archivo $archivo)
    {
        $this->authorize('delete', $archivo);

        Storage::delete($archivo->ruta);
        $archivo->delete();

        return back()->with('success', 'Archivo eliminado correctamente');
    }
}
