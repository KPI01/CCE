<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Empresa extends Recurso
{

    protected $appends = ['ropo'];

    protected $ropo = [
        'tipo' => null,
        'caducidad' => null,
        'nro' => null,
        'tipo_aplicador' => null,
    ];

    public function getRopoAttribute()
    {
        if (
            empty($this->ropo['tipo'])
            && empty($this->ropo['caducidad'])
            && empty($this->ropo['nro'])
            && empty($this->ropo['tipo_aplicador'])
        ) {
            $this->retrieveRopoAttribute();
        }

        return $this->ropo;
    }

    public function setRopoAttribute(array $ropo)
    {
        DB::table('empresa_ropo')->updateOrInsert(
            ['empresa_id' => $this->id],
            [
                'tipo' => $ropo['tipo'] ?? null,
                'caducidad' => isset($ropo['caducidad']) ? date('Y-m-d', strtotime($ropo['caducidad'])) : null,
                'nro' => $ropo['nro'] ?? null,
                'tipo_aplicador' => $ropo['tipo_aplicador'] ?? null,
            ]
        );

        $this->ropo = array_merge($this->ropo, $ropo);
    }

    private function retrieveRopoAttribute()
    {
        $record = DB::table('empresa_ropo')->where('empresa_id', $this->id)->first();

        if ($record) {
            $this->ropo = [
                'tipo' => $record->tipo,
                'caducidad' => $record->caducidad,
                'nro' => $record->nro,
                'tipo_aplicador' => $record->tipo_aplicador,
            ];
        } else {
            $this->ropo = [
                'tipo' => null,
                'caducidad' => null,
                'nro' => null,
                'tipo_aplicador' => null,
            ];
        }
    }

    public function personas(): BelongsToMany
    {
        return $this->belongsToMany(Persona::class)
            ->withTimestamps()
            ->using(EmpresaPersona::class);
    }
}
