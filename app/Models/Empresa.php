<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Empresa extends RecursoBase
{
    const ROPO_TABLE = "empresa_ropo";

    const PERFILES = [
        "productor" => "Productor",
        "aplicador" => "Aplicador",
        "operario" => "Operario",
    ];
    const CAPACITACIONES_ROPO = [
        "basico" => "Básico",
        "cualificado" => "Cualificado",
        "fumigador" => "Fumigador",
        "piloto" => "Piloto Aplicador",
    ];

    protected $attributes = [
        "perfil" => self::PERFILES["productor"],
    ];

    protected $appends = ["ropo", "url"];

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
        $record = DB::table(self::ROPO_TABLE)
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

        if (isset($cad)) {
            $cad = Carbon::parse($cad);
        }
        DB::table(self::ROPO_TABLE)->upsert(
            values: [
                "empresa_id" => $this->id,
                "caducidad" => isset($ropo["caducidad"])
                    ? $cad->format("Y-m-d")
                    : null,
                "nro" => $ropo["nro"] ?? null,
                "capacitacion" => $ropo["capacitacion"] ?? null,
            ],
            uniqueBy: ["empresa_id"],
            update: ["caducidad", "nro", "capacitacion"]
        );

        $this->setUpdatedAt(now());
        $this->save();
    }

    public function personas(): HasMany
    {
        return $this->HasMany(Persona::class)
            ->withTimestamps()
            ->using(EmpresaPersona::class);
    }

    public function maquinas(): HasMany
    {
        return $this->hasMany(Maquina::class)
            ->withTimestamps()
            ->using(EmpresaMaquina::class);
    }
}
