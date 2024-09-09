<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Campana extends RecursoBase
{
    protected $primaryKey = "id";

    public function empresas(): HasMany
    {
        return $this->hasMany(Empresa::class)
            ->withTimestamps()
            ->using(CampanaEmpresa::class);
    }
}
