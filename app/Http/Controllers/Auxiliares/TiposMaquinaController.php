<?php

namespace App\Http\Controllers\Auxiliares;

use App\Http\Controllers\AuxiliaresController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TiposMaquinaController extends AuxiliaresController
{
    public function __construct()
    {
        parent::__construct();
        $this->tableName = "tipos_maquina";
    }
    public function index()
    {
        $data = DB::table($this->tableName)
            ->orderBy("id")
            ->get();
        $cols = Schema::getColumnListing($this->tableName);
        $cols[] = "url";

        $data = $data->map(function (mixed $item, int $key) {
            $item->url = url("app/config/auxiliares/{$item->id}");
            return $item;
        });

        return inertia("Config/Auxiliares/Maquina/Tipos", [
            "data" => ["cols" => $cols, "values" => $data],
            "url" => url("app/config/auxiliares/tipos_maquinas"),
        ]);
    }
}
