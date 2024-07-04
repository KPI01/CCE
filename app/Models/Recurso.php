<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    use HasFactory, HasUuids;

    protected $appends = ["relaciones"];
    protected $relaciones = [];

    public function getRelacionesAttribute()
    {
        if (empty($this->relaciones)) {
            $this->constructRelacionesAttribute();
        }
        return $this->relaciones;
    }

    public function setRelacionesAttribute(array $relaciones)
    {
        $aux = $this->getArrayableRelations();

        $this->relaciones = array_merge($relaciones, $aux);
    }

    protected function constructRelacionesAttribute()
    {
        $aux = $this->getArrayableRelations();
        $this->relaciones = array_merge($aux, $this->relaciones);
    }
}
