<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Maquina extends RecursoBase
{
    const TIPOS_TABLE = "tipos_maquina";
    protected $appends = ["url"];

    public function getTipoAttribute($value)
    {
        $data = DB::table(self::TIPOS_TABLE)
            ->where("id", $value)
            ->first();

        return $data->tipo;
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class)
            ->withTimestamps()
            ->using(EmpresaMaquina::class);
    }
}
