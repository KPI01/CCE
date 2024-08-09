<?php

namespace App\Http\Controllers\Auxiliares;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MaquinaAuxiliaresController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        foreach ($this->toasts["exito"] as $key => $value) {
            $this->toastExitoConstructor(
                accion: $key,
                seccion: "title",
                append: "Tipos Máquina (Auxiliares)"
            );
        }
    }

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
        $data = $request->all();

        DB::table($tabla)->insert($data);

        $this->toastExitoConstructor(
            accion: "store",
            seccion: "description",
            append: $data["nombre"]
        );

        return to_route("aux_maquina.index", $tabla)->with([
            "from" => "aux_maquina.store",
            "message" => [
                "toast" => $this->toasts["exito"]["store"],
            ],
        ]);
    }

    public function update(Request $request, string $tabla, int $id)
    {
        //
        $data = $request->all();

        $old = DB::table($tabla)->where("id", $id)->first();

        DB::table($tabla)
            ->where("id", $old->id)
            ->update($data);

        $new = DB::table($tabla)
            ->where("id", $old->id)
            ->first();

        $this->toastExitoConstructor(
            accion: "update",
            seccion: "description",
            append: "{$new->nombre} (Anteriormente: {$old->nombre})"
        );

        return to_route("aux_maquina.index", [$tabla, $id])->with([
            "from" => "aux_maquina.update",
            "message" => [
                "toast" => $this->toasts["exito"]["update"],
            ],
        ]);
    }

    public function destroy(string $tabla, int $id)
    {
        //
        $row = DB::table($tabla)->where("id", $id)->first();

        DB::table($tabla)
            ->where("id", $row->id)
            ->delete();

        $this->toastExitoConstructor(
            accion: "destroy",
            seccion: "description",
            append: $row->nombre
        );

        return to_route("aux_maquina.index", $tabla)->with([
            "from" => "aux_maquina.destroy",
            "message" => ["toast" => $this->toasts["exito"]["destroy"]],
        ]);
    }
}
