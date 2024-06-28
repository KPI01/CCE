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
    protected $ropo = [];

    private function getParentAppends()
    {
        return (new parent)->getArrayableAppends();
    }

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->appends = array_merge($this->appends, $this->getParentAppends());
    }

    public function getRopoAttribute() 
    {
        if (empty($this->ropo)) {
            $this->retrieveRopoAttribute();
        }

        return $this->ropo;
    }

    public function setRopoAttribute(array $ropo) 
    {
        $this->ropo = $ropo;
    }

    private function retrieveRopoAttribute() 
    {
        $exists = DB::table('persona_ropo')->where('persona_id', $this->id)->exists();
        
        if ($exists) {
            $aux = (array)DB::table('persona_ropo')->where('persona_id', $this->id)->first();
            unset($aux['persona_id']);

            return $this->setRopoAttribute($aux);
        } 

        return $this->setRopoAttribute([]);
    }

    public function empresas(): BelongsToMany {
        return $this->belongsToMany(Empresa::class)
            ->withTimestamps()
            ->using(EmpresaPersona::class);
    }
}
