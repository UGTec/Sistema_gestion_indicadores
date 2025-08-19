<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Archivo extends Model
{
    protected $fillable = [
        'nombre_original',
        'nombre_guardado',
        'ruta',
        'mime_type',
        'tamanho',
        'archivable_id',
        'archivable_type'
    ];

    public function archivable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getTamanhoFormateadoAttribute()
    {
        $bytes = $this->tamanho;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return $bytes . ' byte';
        } else {
            return '0 bytes';
        }
    }
}
