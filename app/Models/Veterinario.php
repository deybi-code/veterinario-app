<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Veterinario extends Model
{
    protected $fillable = ['nombre', 'especialidad'];

    public function atenciones(): HasMany
    {
        return $this->hasMany(Atencion::class);
    }
}