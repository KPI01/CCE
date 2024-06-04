<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Persona extends Model
{
    use HasFactory, HasUuids;

    public function empresas(): BelongsToMany {
        return $this->belongsToMany(Empresa::class)
            ->withTimestamps()
            ->using(EmpresaPersona::class);
    }
}
