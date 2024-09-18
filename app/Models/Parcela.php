<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Parcela extends RecursoBase
{
    protected $touches = ["empresa", "persona", "campana"];
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(related: Empresa::class, foreignKey: "id");
    }

    public function productor(): BelongsTo
    {
        return $this->belongsTo(related: Persona::class, foreignKey: "id");
    }

    public function campana(): BelongsTo
    {
        return $this->belongsTo(related: Campana::class, foreignKey: "id");
    }
}
