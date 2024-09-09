<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Campana extends RecursoBase
{
    protected $primaryKey = "id";

    protected function casts(): array
    {
        return [
            "inicio" => "datetime:d/m/Y",
            "fin" => "datetime:d/m/Y",
        ];
    }

    public function empresas(): HasMany
    {
        return $this->hasMany(Empresa::class)
            ->withTimestamps()
            ->using(CampanaEmpresa::class);
    }
}
