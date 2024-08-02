<?php

namespace App\Models;

use Carbon\Carbon;
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

    protected $appends = ["ropo", "urls"];
    protected $ropo = [
        "tipo" => null,
        "caducidad" => null,
        "nro" => null,
        "tipo_aplicador" => null,
    ];

    protected $casts = [
        "ropo" => "array",
    ];

    protected $attributes = [
        "perfil" => self::PERFILES["productor"],
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

        isset($record)
            ? ($this->ropo = [
                "caducidad" => Carbon::parse($record->caducidad)->format(
                    "Y-m-d"
                ),
                "nro" => $record->nro,
                "capacitacion" => $record->capacitacion,
            ])
            : ($this->ropo = [
                "caducidad" => null,
                "nro" => null,
                "capacitacion" => null,
            ]);
    }

    private function upsertRopoAttribute(array $ropo)
    {
        $cad = $ropo["caducidad"];

        if (isset($cad)) {
            $cad = Carbon::parse($cad);
        }

        DB::table(self::ROPO_TABLE)->upsert(
            values: [
                "persona_id" => $this->id,
                "caducidad" => isset($ropo["caducidad"])
                    ? $cad->format("Y-m-d")
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
