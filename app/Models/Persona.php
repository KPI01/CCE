<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Persona extends Recurso
{
    protected $guard = [];
    protected $appends = ["ropo"];
    protected $ropo = [
        "tipo" => null,
        "caducidad" => null,
        "nro" => null,
        "tipo_aplicador" => null,
    ];

    private function getParentAppends()
    {
        return (new parent())->getArrayableAppends();
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge($this->appends, $this->getParentAppends());
    }

    public function getRopoAttribute()
    {
        if (
            empty($this->ropo["capacitacion"]) &&
            empty($this->ropo["caducidad"]) &&
            empty($this->ropo["nro"])
        ) {
            $this->retrieveRopoAttribute();
        }

        return $this->ropo;
    }

    public function setRopoAttribute(array $ropo)
    {
        // dd($ropo);
        if (!is_null($ropo["capacitacion"]) && !is_null($ropo["nro"])) {
            DB::table("persona_ropo")->updateOrInsert(
                ["persona_id" => $this->id],
                [
                    "capacitacion" => $ropo["capacitacion"],
                    "caducidad" => isset($ropo["caducidad"])
                        ? date("Y-m-d", strtotime($ropo["caducidad"]))
                        : null,
                    "nro" => $ropo["nro"],
                ]
            );
        }

        $this->ropo = array_merge($this->ropo, $ropo);
    }

    private function retrieveRopoAttribute()
    {
        $record = DB::table("persona_ropo")
            ->where("persona_id", $this->id)
            ->first();

        if ($record) {
            $this->ropo = [
                "capacitacion" => $record->capacitacion,
                "caducidad" => $record->caducidad,
                "nro" => $record->nro,
            ];
        } else {
            $this->ropo = [
                "capacitacion" => null,
                "caducidad" => null,
                "nro" => null,
            ];
        }
    }

    public function empresas(): BelongsToMany
    {
        return $this->belongsToMany(Empresa::class)
            ->withTimestamps()
            ->using(EmpresaPersona::class);
    }

    public function update(array $attributes = [], array $options = [])
    {
        if (isset($attributes["ropo"])) {
            $this->setRopoAttribute($attributes["ropo"]);
            unset($attributes["ropo"]);
        }

        return parent::update($attributes, $options);
    }
}
