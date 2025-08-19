<?php

namespace App\Traits;

use App\Models\Archivo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait ManejaArchivos
{
    public function guardarArchivos($archivos, $modelo, $directorio = 'archivos')
    {
        $archivosGuardados = [];

        foreach ($archivos as $archivo) {
            if ($archivo instanceof UploadedFile) {
                $nombreOriginal = $archivo->getClientOriginalName();
                $extension = $archivo->getClientOriginalExtension();
                $nombreGuardado = uniqid() . '.' . $extension;
                $ruta = $archivo->storeAs($directorio, $nombreGuardado);

                $archivosGuardados[] = $modelo->archivos()->create([
                    'nombre_original' => $nombreOriginal,
                    'nombre_guardado' => $nombreGuardado,
                    'ruta' => $ruta,
                    'mime_type' => $archivo->getClientMimeType(),
                    'tamanho' => $archivo->getSize(),
                ]);
            }
        }

        return $archivosGuardados;
    }
}
