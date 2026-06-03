<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Atencion extends Model
{
    protected $table = 'atenciones';

    protected $fillable = ['veterinario_id', 'mascota', 'diagnostico', 'fecha', 'imagen'];

    public function veterinario(): BelongsTo
    {
        return $this->belongsTo(Veterinario::class);
    }
}