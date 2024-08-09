<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Maquina extends RecursoBase
{
    const TIPOS_TABLE = "tipos_maquina";
    protected $appends = ["url", "tipo"];
    protected $tipo;
    protected $casts = [
        "tipo" => "string",
    ];

    public function getTipoAttribute()
    {
        $data = DB::table(self::TIPOS_TABLE)
            ->where("id", $this->tipo_id)
            ->first();

        $this->tipo = $data->nombre;
        return $this->tipo;
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class)
            ->withTimestamps()
            ->using(EmpresaMaquina::class);
    }
}
