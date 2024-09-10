<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Campana extends RecursoBase
{
    protected $primaryKey = "id";

    protected function casts(): array
    {
        return array_merge(
            [
                "is_activa" => "boolean",
                "inicio" => "datetime:Y-m-d",
                "fin" => "datetime:Y-m-d",
            ],
            parent::casts()
        );
    }

    public function empresas(): HasMany
    {
        return $this->hasMany(Empresa::class)
            ->withTimestamps()
            ->using(CampanaEmpresa::class);
    }
}
