<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int                             $id
 * @property string                          $nombre_original
 * @property string                          $nombre_guardado
 * @property string                          $ruta
 * @property string                          $mime_type
 * @property int                             $tamanho
 * @property string                          $archivable_type
 * @property int                             $archivable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $archivable
 * @property-read mixed $tamanho_formateado
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Archivo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Archivo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Archivo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Archivo whereArchivableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Archivo whereArchivableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Archivo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Archivo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Archivo whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Archivo whereNombreGuardado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Archivo whereNombreOriginal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Archivo whereRuta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Archivo whereTamanho($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Archivo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
