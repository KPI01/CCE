<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Persona extends RecursoBase
{
    const ROPO_TABLE = "persona_ropo";
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
    const TIPO_ID_NAC = [
        "dni" => "DNI",
        "nie" => "NIE",
    ];

    protected $attributes = [
        "perfil" => self::PERFILES["productor"],
    ];

    protected $appends = ["ropo"];
    protected $ropo = [
        "tipo" => null,
        "caducidad" => null,
        "nro" => null,
        "tipo_aplicador" => null,
    ];

    protected $casts = [
        "ropo" => "array",
    ];

    public function getRopoAttribute()
    {
        $this->retrieveRopoAttribute();

        return $this->ropo;
    }

    public function setRopoAttribute(array $ropo): Persona
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
            ->where("persona_id", $this->id)
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
            $cad = strtotime($cad);
        }
        DB::table(self::ROPO_TABLE)->upsert(
            values: [
                "persona_id" => $this->id,
                "caducidad" => isset($ropo["caducidad"])
                    ? date("Y-m-d", $cad)
                    : null,
                "nro" => $ropo["nro"] ?? null,
                "capacitacion" => $ropo["capacitacion"] ?? null,
            ],
            uniqueBy: ["persona_id"],
            update: ["caducidad", "nro", "capacitacion"]
        );

        $this->setUpdatedAt(now());
        $this->save();
    }

    public function empresas(): BelongsToMany
    {
        return $this->belongsToMany(Empresa::class)
            ->withTimestamps()
            ->using(EmpresaPersona::class);
    }

}
