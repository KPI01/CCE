<?php

namespace App\Http\Controllers\Auxiliares;

use App\Http\Controllers\AuxiliaresController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TiposMaquinaController extends AuxiliaresController
{
    public function __construct()
    {
        $this->tableName = "tipos_maquina";
    }
    public function index(string $tableName)
    {
        $data = DB::table($this->tableName)
            ->orderBy("id")
            ->get();
        return inertia("");
    }
}
