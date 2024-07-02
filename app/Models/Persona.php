<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Persona extends Recurso
{
    protected $fillable = [
        'id',
        'nombres',
        'apellidos',
        'tipo_id_nac',
        'id_nac',
        'email',
    ];

    protected $appends = ['ropo'];
    protected $ropo = [
        'tipo' => null,
        'caducidad' => null,
        'nro' => null,
        'tipo_aplicador' => null,
    ];

    private function getParentAppends()
    {
        return (new parent)->getArrayableAppends();
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge($this->appends, $this->getParentAppends());
    }

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
        DB::table('persona_ropo')->updateOrInsert(
            ['persona_id' => $this->id],
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
        $record = DB::table('persona_ropo')->where('persona_id', $this->id)->first();

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

    public function empresas(): BelongsToMany
    {
        return $this->belongsToMany(Empresa::class)
            ->withTimestamps()
            ->using(EmpresaPersona::class);
    }

    public function update(array $attributes = [], array $options = [])
    {
        if (isset($attributes['ropo'])) {
            $this->setRopoAttribute($attributes['ropo']);
            unset($attributes['ropo']);
        }

        return parent::update($attributes, $options);
    }
}
