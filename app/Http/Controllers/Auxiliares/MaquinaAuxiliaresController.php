<?php

namespace App\Http\Controllers\Auxiliares;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MaquinaAuxiliaresController extends Controller
{
    public function index(Request $request, string $tabla = "tipos_maquina")
    {
        //
        if (!Schema::hasTable($tabla)) {
            throw new Exception("La tabla {$tabla} no existe");
        } elseif (!str_contains($request->path(), $tabla)) {
            return to_route("aux_maquina.index", $tabla);
        }

        $cols = Schema::getColumnListing($tabla);
        $cols[] = "urls";
        $rows = DB::table($tabla)->orderBy("id")->get();
        $rows = $rows->map(function ($row) use ($tabla) {
            $row->url = route("aux_maquina.update", [
                "tabla" => $tabla,
                "id" => $row->id,
            ]);
            return $row;
        });
        $name = explode("_", $tabla);
        $name = array_map(function ($item) {
            return ucfirst($item);
        }, $name);
        $name = implode(" ", $name);

        return inertia("Config/Auxiliares/Recursos/Maquina", [
            "title" => $name,
            "cols" => $cols,
            "rows" => $rows,
            "url" => route("aux_maquina.index", $tabla),
        ]);
    }

    public function store(Request $request, string $tabla)
    {
        //
    }

    public function update(Request $request, string $tabla, int $id)
    {
        //
        $data = $request->all();
        $keys = array_keys($data);
        foreach ($keys as $key) {
            DB::table($tabla)
                ->where("id", $id)
                ->update([$key => $data[$key]]);
        }

        return to_route("aux_maquina.index", [$tabla, $id]);
    }

    public function destroy(string $tabla, int $id)
    {
        //
        DB::table($tabla)->where("id", $id)->delete();
        return to_route("aux_maquina.index", $tabla);
    }
}
