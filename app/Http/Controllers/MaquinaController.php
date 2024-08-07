<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaquinaController extends Controller
{
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
    }

    public function index()
    {
        //
        $this->data = Maquina::all();
        return inertia("Recursos/Maquinas/Table", [
            "data" => $this->data,
            "url" => route("maquina.index"),
        ]);
    }

    public function create()
    {
        //
        $aux = DB::table(Maquina::TIPOS_TABLE)
            ->orderBy("id")
            ->get()
            ->pluck("tipo")
            ->toArray();
        return inertia("Recursos/Maquinas/Create", [
            "aux" => ["tipos" => $aux],
            "url" => route("maquina.index"),
        ]);
    }

    public function store(Request $request)
    {
        //
        $data = $request->all();
        $uniques = $request->all(["matricula"]);

        $tipo_id = DB::table(Maquina::TIPOS_TABLE)
            ->where("tipo", $data["tipo"])
            ->first();

        $data["tipo"] = $tipo_id->id;

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
            append: $inst->nombre . " (" . $inst->matricula . ")"
        );
        return to_route("maquina.index")->with([
            "from" => "maquina.store",
            "message" => ["toast" => $this->toasts["exito"]["store"]],
        ]);
    }

    public function show(string $id)
    {
        //
        $data = Maquina::findOrFail($id);
        $aux = [
            "tipos" => DB::table(Maquina::TIPOS_TABLE)
                ->get()
                ->pluck("tipo")
                ->toArray(),
        ];
        return inertia("Recursos/Maquinas/Show", [
            "data" => $data,
            "aux" => $aux,
        ]);
    }

    public function edit(string $id)
    {
        //
        $data = Maquina::findOrFail($id);
        $aux = [
            "tipos" => DB::table(Maquina::TIPOS_TABLE)
                ->get()
                ->pluck("tipo")
                ->toArray(),
        ];

        return inertia("Recursos/Maquinas/Edit", [
            "data" => $data,
            "aux" => $aux,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $inst = Maquina::findOrFail($id);
        $data = $request->all();
        $uniques = $request->all(["matricula"]);

        if (is_null($uniques["matricula"])) {
            $uniques["matricula"] = $inst->matricula;
        }

        if (
            Maquina::where([
                ["matricula", $uniques["matricula"]],
                ["id", "<>", $inst->id],
            ])->exists()
        ) {
            $this->toastErrorConstructor(
                campo: "matricula",
                error: "Duplicidad",
                mensaje: implode(" ", [
                    "La matrícula",
                    "[{$uniques["matricula"]}]",
                    "ya se encuentra registrada",
                ]),
                variante: "warning"
            );
            return to_route("maquina.show", $inst->id)->with([
                "from" => "maquina.update",
                "message" => [
                    "toast" => $this->toasts["error"]["matricula:duplicidad"],
                ],
            ]);
        }

        $inst->update($data);
        $inst->save();

        $this->toastExitoConstructor(
            accion: "update",
            seccion: "description",
            append: implode(" ", [$inst->nombre, "[{$inst->matricula}]"])
        );

        return to_route("maquina.show", $inst->id)->with([
            "from" => "maquina.update",
            "message" => [
                "toast" => $this->toasts["exito"]["update"],
            ],
        ]);
    }

    public function destroy(string $id)
    {
        //
        $this->data = Maquina::findOrFail($id);
        $this->data->delete();
        return to_route("maquina.index")->with([
            "from" => "maquina.destroy",
            "message" => [
                "toast" => [
                    "variant" => "destructive",
                    "title" => "Recurso: Máquina",
                    "description" => implode([
                        $this->data->nombre,
                        " ",
                        "({$this->data->matricula})",
                        " ",
                        "se ha eliminado de los registros.",
                    ]),
                ],
            ],
        ]);
    }

    public function auxTipos_index()
    {
        $data = DB::table(Maquina::TIPOS_TABLE)
            ->get()
            ->toArray();

        return inertia("Config/Auxiliares/Maquina", [
            "data" => $data,
        ]);
    }
}
