<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $url
 * @property string|null $description
 * @property string $width
 * @property string $height
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Iframe active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Iframe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Iframe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Iframe query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Iframe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Iframe whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Iframe whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Iframe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Iframe whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Iframe whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Iframe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Iframe whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Iframe whereWidth($value)
=======
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property        int                                                  $id
 * @property        string                                               $name
 * @property        string                                               $url
 * @property        string|null                                          $description
 * @property        string                                               $width
 * @property        string                                               $height
 * @property        bool                                                 $is_active
 * @property        \Illuminate\Support\Carbon|null                      $created_at
 * @property        \Illuminate\Support\Carbon|null                      $updated_at
 * @method   static \Illuminate\Database\Eloquent\Builder<static>|Iframe active()
 * @method   static \Illuminate\Database\Eloquent\Builder<static>|Iframe newModelQuery()
 * @method   static \Illuminate\Database\Eloquent\Builder<static>|Iframe newQuery()
 * @method   static \Illuminate\Database\Eloquent\Builder<static>|Iframe query()
 * @method   static \Illuminate\Database\Eloquent\Builder<static>|Iframe whereCreatedAt($value)
 * @method   static \Illuminate\Database\Eloquent\Builder<static>|Iframe whereDescription($value)
 * @method   static \Illuminate\Database\Eloquent\Builder<static>|Iframe whereHeight($value)
 * @method   static \Illuminate\Database\Eloquent\Builder<static>|Iframe whereId($value)
 * @method   static \Illuminate\Database\Eloquent\Builder<static>|Iframe whereIsActive($value)
 * @method   static \Illuminate\Database\Eloquent\Builder<static>|Iframe whereName($value)
 * @method   static \Illuminate\Database\Eloquent\Builder<static>|Iframe whereUpdatedAt($value)
 * @method   static \Illuminate\Database\Eloquent\Builder<static>|Iframe whereUrl($value)
 * @method   static \Illuminate\Database\Eloquent\Builder<static>|Iframe whereWidth($value)
>>>>>>> aa75e952fac1efc1436eef8f1edcee7dd9adb13a
 * @mixin \Eloquent
 */
class Iframe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'description',
        'width',
        'height',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope para obtener solo iframes activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Validar que la URL sea válida
     */
    public function isValidUrl()
    {
        return filter_var($this->url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Normalizar el valor de ancho/alto
     */
    public function normalizeSize($value)
    {
        $value = trim($value);

        // Si es un número sin unidad, agregar 'px'
        if (is_numeric($value)) {
            return $value . 'px';
        }

        // Si ya tiene unidad válida, devolverlo tal como está
        if (preg_match('/^(auto|inherit|\d+(%|px|em|rem|vh|vw))$/', $value)) {
            return $value;
        }

        // Si no es válido, devolver valor por defecto
        return '100%';
    }

    /**
     * Accessor para width
     */
    public function getWidthAttribute($value)
    {
        return $this->normalizeSize($value);
    }

    /**
     * Accessor para height
     */
    public function getHeightAttribute($value)
    {
        return $this->normalizeSize($value);
    }

    /**
     * Mutador para el height normalizado
     */
    // public function setHeightAttribute($value)
    // {
    //     $this->attributes['height'] = $this->normalizeSize($value);
    // }

    /**
     * Mutador para el width normalizado
     */
    // public function setWidthAttribute($value)
    // {
    //     $this->attributes['width'] = $this->normalizeSize($value);
    // }

    /**
     * Boot method para manejar el iframe activo único
     */
    protected static function boot()
    {
        parent::boot();

        // Antes de crear un iframe activo, desactivar todos los demás
        static::creating(function ($iframe) {
            if ($iframe->is_active) {
                static::where('is_active', true)->update(['is_active' => false]);
            }
        });

        // Antes de actualizar un iframe a activo, desactivar todos los demás
        static::updating(function ($iframe) {
            if ($iframe->is_active && $iframe->isDirty('is_active')) {
                static::where('is_active', true)
                    ->where('id', '!=', $iframe->id)
                    ->update(['is_active' => false]);
            }
        });
    }
}
