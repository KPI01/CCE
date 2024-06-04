<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Empresa extends Model
{
    use HasFactory, HasUuids;

    public function personas(): BelongsToMany {
        return $this->belongsToMany(Persona::class)
            ->withTimestamps()
            ->using(EmpresaPersona::class);
    }
}
