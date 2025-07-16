<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property string $cod_division
 * @property string $division
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Departamento> $departamentos
 * @property-read int|null $departamentos_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereCodDivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Division whereDivision($value)
 * @mixin \Eloquent
 */
class Division extends Model
{
    protected $table      = 'division';
    protected $primaryKey = 'cod_division';
    public $incrementing  = false;
    protected $keyType    = 'decimal';
    public $timestamps    = false;

    protected $fillable = [
        'cod_division',
        'division'
    ];

    public function departamentos()
    {
        return $this->hasMany(Departamento::class, 'cod_division', 'cod_division');
    }
}
