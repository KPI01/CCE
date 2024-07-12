<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Empresa extends RecursoBase
{
    protected $keyType = "string";
    public $incrementing = false;

    protected $attributes = [
        "perfil" => "Aplicador",
    ];

    protected $guarded = [];

    protected $appends = ["ropo"];

    protected $ropo = [
        "caducidad" => null,
        "nro" => null,
        "capacitacion" => null,
    ];

    protected $casts = [
        "ropo" => "array",
    ];

    public function getRopoAttribute()
    {
        $this->retrieveRopoAttribute();

        return $this->ropo;
    }

    public function setRopoAttribute(array $ropo): Empresa
    {
        if (!empty($ropo["caducidad"])) {
            $ropo["caducidad"] = date("Y-m-d", strtotime($ropo["caducidad"]));
        }

        $this->upsertRopoAttribute($ropo);
        $this->ropo = array_merge($this->ropo, $ropo);

        return $this;
    }

    private function retrieveRopoAttribute()
    {
        $record = DB::table("empresa_ropo")
            ->where("empresa_id", $this->id)
            ->first();

        if ($record) {
            $this->ropo = [
                "caducidad" => $record->caducidad,
                "nro" => $record->nro,
                "capacitacion" => $record->capacitacion,
            ];
        } else {
            $this->ropo = [
                "caducidad" => null,
                "nro" => null,
                "capacitacion" => null,
            ];
        }
    }

    private function upsertRopoAttribute(array $ropo)
    {
        $cad = $ropo["caducidad"];
        $nro = $ropo["nro"];

        if (isset($cad)) {
            $cad = strtotime($cad);
        } elseif (isset($nro)) {
            DB::table("empresa_ropo")->upsert(
                values: [
                    "empresa_id" => $this->id,
                    "caducidad" => isset($ropo["caducidad"])
                        ? date("Y-m-d", $cad)
                        : null,
                    "nro" => $ropo["nro"] ?? null,
                    "capacitacion" => $ropo["capacitacion"] ?? null,
                ],
                uniqueBy: ["empresa_id", "nro"],
                update: ["caducidad", "nro", "capacitacion"]
            );
        }

        $this->setUpdatedAt(now());
        $this->save();
    }

    public function personas(): BelongsToMany
    {
        return $this->belongsToMany(Persona::class)
            ->withTimestamps()
            ->using(EmpresaPersona::class);
    }
}
