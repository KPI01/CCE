<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    use HasFactory, HasUuids;


    protected $appends = ['urls', 'relaciones'];
    protected $urls = [];
    protected $relaciones = [];


    public function getRelacionesAttribute()
    {
        if (empty($this->relaciones)) {
            $this->constructRelacionesAttribute();
        }
        return $this->relaciones;
    }

    public function getUrlsAttribute()
    {
        if (empty($this->urls)) {
            $this->constructUrls();
        }
        return $this->urls;
    }

    public function setRelacionesAttribute(array $relaciones)
    {
        $aux = $this->getArrayableRelations();

        $this->relaciones = array_merge($relaciones, $aux);
    }

    public function setUrlsAttribute(array $urls)
    {
        $this->$urls = $urls;
    }

    protected function constructUrls()
    {
        $table = $this->getTable();
        $paramName = substr($table, -1) === 's' ? substr($table, 0, -1) : $table;

        $this->urls = [
            'edit' => route("$table.edit", [$paramName => $this->getKey()]),
            'destroy' => route("$table.destroy", [$paramName => $this->getKey()]),
            'show' => route("$table.show", [$paramName => $this->getKey()]),
            'update' => route("$table.update", [$paramName => $this->getKey()]),
        ];
    }

    protected function constructRelacionesAttribute()
    {
        $aux = $this->getArrayableRelations();
        $this->relaciones = array_merge($aux, $this->relaciones);
    }
}
