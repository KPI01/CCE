<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function empresas(): BelongsToMany
    {
        return $this->hasMany(related: Empresa::class)
            ->withTimestamps()
            ->using(CampanaEmpresa::class);
    }

    public function parcelas(): HasMany
    {
        return $this->hasMany(
            related: Parcela::class,
            foreignKey: "campana_id"
        );
    }
}
