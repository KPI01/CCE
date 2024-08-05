<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Maquina extends RecursoBase
{
    protected $appends = ["urls"];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class)
            ->withTimestamps()
            ->using(EmpresaMaquina::class);
    }
}
