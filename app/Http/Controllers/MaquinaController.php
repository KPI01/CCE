<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaquinaController extends Controller
{
    public array $aux;
    public function __construct()
    {
        parent::__construct();

        $this->tableName = (new Maquina())->getTable();

        foreach ($this->toasts["exito"] as $key => $value) {
            $this->toastExitoConstructor(
                accion: $key,
                seccion: "title",
                append: "Máquina"
            );
        }

        $this->aux["tipos"] = DB::table(Maquina::TIPOS_TABLE)
            ->orderBy("id")
            ->pluck("nombre")
            ->toArray();
    }

    public function index()
    {
        //
        $data = Maquina::all();
        $url = route("maquina.create");

        return inertia("Recursos/Maquina/Table", compact("data", "url"));
    }

    public function create()
    {
        //
        return inertia("Recursos/Maquina/Create", [
            "aux" => $this->aux,
            "url" => route("maquina.index"),
        ]);
    }

    public function store(Request $request)
    {
        //
        $data = $request->all();
        $uniques = $request->all(["matricula"]);

        $tipo_id = DB::table(Maquina::TIPOS_TABLE)
            ->where("nombre", $data["tipo"])
            ->pluck("id")
            ->first();

        if (isset($data["cad_iteaf"])) {
            $data["cad_iteaf"] =
                Carbon::parse($data["cad_iteaf"])->format("Y-m-d") ?? null;
        }
        $data["tipo_id"] = $tipo_id;
        unset($data["tipo"]);

        if (
            $this->valueExists(
                table: $this->tableName,
                column: "matricula",
                value: $uniques["matricula"]
            )
        ) {
            return to_route("maquina.index")->with([
                "from" => "maquina.store",
                "message" => $this->toasts["error"]["matricula:duplicado"],
            ]);
        }

        $inst = Maquina::create($data);
        $this->toastExitoConstructor(
            accion: "store",
            seccion: "description",
            append: "{$inst->nombre} ({$inst->matricula})"
        );
        return to_route("maquina.index")->with([
            "from" => "maquina.store",
            "message" => ["toast" => $this->toasts["exito"]["store"]],
        ]);
    }

    public function show(Maquina $maquina)
    {
        //
        return inertia("Recursos/Maquina/Show", [
            "data" => $maquina,
            "aux" => $this->aux,
        ]);
    }

    public function edit(Maquina $maquina)
    {
        //
        return inertia("Recursos/Maquina/Edit", [
            "data" => $maquina,
            "aux" => $this->aux,
        ]);
    }

    public function update(Request $request, Maquina $maquina)
    {
        //
        $data = $request->all();
        $uniques = $request->all(["matricula"]);

        if (is_null($uniques["matricula"])) {
            $uniques["matricula"] = $maquina->matricula;
        }

        if (
            Maquina::where([
                ["matricula", $uniques["matricula"]],
                ["id", "<>", $maquina->id],
            ])->exists()
        ) {
            $this->toastErrorConstructor(
                campo: "matricula",
                error: "Duplicidad",
                mensaje: "La matrícula [{$uniques["matricula"]}] ya se encuentra registrada",
                variante: "warning"
            );
            return to_route("maquina.show", $maquina->id)->with([
                "from" => "maquina.update",
                "message" => [
                    "toast" => $this->toasts["error"]["matricula:duplicidad"],
                ],
            ]);
        }

        $maquina->update($data);
        $maquina->save();

        $this->toastExitoConstructor(
            accion: "update",
            seccion: "description",
            append: "{$maquina->nombre} [{$maquina->matricula}]"
        );

        return to_route("maquina.show", $maquina->id)->with([
            "from" => "maquina.update",
            "message" => [
                "toast" => $this->toasts["exito"]["update"],
            ],
        ]);
    }

    public function destroy(Maquina $maquina)
    {
        //
        $maquina->delete();

        $this->toastExitoConstructor(
            accion: "destroy",
            seccion: "description",
            append: "{$maquina->nombre} ({$maquina->matricula})"
        );
        return to_route("maquina.index")->with([
            "from" => "maquina.destroy",
            "message" => [
                "toast" => $this->toasts["exito"]["destroy"],
            ],
        ]);
    }

    public function indexAux(Request $request, string $tabla)
    {
        //
        $data = DB::table($tabla)->get();

        return inertia("Recursos/Maquina/Auxiliares", compact("data", "tabla"));
    }
}
