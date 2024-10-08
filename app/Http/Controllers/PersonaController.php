<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonaController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->tableName = (new Persona())->getTable();

        foreach ($this->toasts["exito"] as $key => $value) {
            $this->toastExitoConstructor(
                accion: $key,
                seccion: "title",
                append: "Persona"
            );
        }
    }

    public function index()
    {
        //
        $data = Persona::all();
        $url = route("persona.create");

        return inertia("Recursos/Persona/Table", compact("data", "url"));
    }

    public function create()
    {
        //
        return inertia("Recursos/Persona/Create", [
            "url" => route("persona.index"),
        ]);
    }

    public function store(Request $request)
    {
        //
        $basic = $request->all();
        unset($basic["ropo"]);
        $uniques = $request->all(["email", "id_nac"]);

        if (
            $this->valueExists(
                table: $this->tableName,
                column: "email",
                value: $uniques["email"]
            )
        ) {
            return to_route("persona.index")->with([
                "from" => "persona.store",
                "message" => [
                    "toast" => $this->toasts["error"]["email:duplicado"],
                ],
            ]);
        } elseif (
            $this->valueExists(
                table: $this->tableName,
                column: "id_nac",
                value: $uniques["id_nac"]
            )
        ) {
            return to_route("persona.index")->with([
                "from" => "persona.store",
                "message" => [
                    "toast" => $this->toasts["error"]["id_nac:duplicado"],
                ],
            ]);
        } else {
            $r = $request->input("ropo");

            if (isset($r)) {
                if (
                    $this->valueExists(
                        table: Persona::ROPO_TABLE,
                        column: "nro",
                        value: $r["nro"]
                    )
                ) {
                    return to_route("persona.index")->with([
                        "from" => "persona.store",
                        "message" => [
                            "toast" =>
                                $this->toasts["error"]["ropo.nro:duplicado"],
                        ],
                    ]);
                }
                $inst = Persona::create($basic)->setRopoAttribute($r);
            } else {
                $inst = Persona::create($basic);
            }
            $this->toastExitoConstructor(
                accion: "store",
                seccion: "description",
                append: "{$inst->nombres} {$inst->apellidos} ({$inst->id_nac})"
            );
            return to_route("persona.index")->with([
                "from" => "persona.store",
                "message" => [
                    "toast" => $this->toasts["exito"]["store"],
                ],
            ]);
        }
    }

    public function show(Persona $persona)
    {
        //
        return inertia("Recursos/Persona/Show", [
            "data" => $persona,
        ]);
    }

    public function edit(Persona $persona)
    {
        //
        return inertia("Recursos/Persona/Edit", [
            "data" => $persona,
        ]);
    }

    public function update(Request $request, Persona $persona)
    {
        //
        $basic = $request->all();
        unset($basic["ropo"]);
        $uniques = $request->all(["email", "id_nac"]);

        if (
            Persona::where([
                ["email", $uniques["email"]],
                ["id", "<>", $persona->id],
            ])->exists()
        ) {
            $this->toastErrorConstructor(
                campo: "email",
                error: "Duplicado",
                mensaje: "Correo: {$uniques["email"]} ya se encuentra registrado",
                variante: "warning"
            );
            return to_route("persona.edit", $persona->id)->with([
                "from" => "persona.update",
                "message" => [
                    "toast" => $this->toasts["error"]["email:duplicado"],
                ],
            ]);
        } elseif (
            Persona::where([
                ["id_nac", $uniques["id_nac"]],
                ["id", "<>", $persona->id],
            ])->exists()
        ) {
            $this->toastErrorConstructor(
                campo: "id_nac",
                error: "Duplicado",
                mensaje: "NIF: {$uniques["id_nac"]} ya se encuentra registrado",
                variante: "warning"
            );
            return to_route("persona.edit", $persona->id)->with([
                "from" => "persona.update",
                "message" => [
                    "toast" => $this->toasts["error"]["id_nac:duplicado"],
                ],
            ]);
        } else {
            $r = $request->input("ropo");

            if (isset($r)) {
                if (
                    DB::table(Persona::ROPO_TABLE)
                        ->where("nro", $r["nro"])
                        ->where("persona_id", "<>", $persona->id)
                        ->exists()
                ) {
                    $this->toastErrorConstructor(
                        campo: "ropo.nro",
                        error: "Duplicado",
                        mensaje: "Nº ROPO: {$r["nro"]} ya se encuentra registrado",
                        variante: "warning"
                    );
                    return to_route("persona.edit", $persona->id)->with([
                        "from" => "persona.update",
                        "message" => [
                            "toast" =>
                                $this->toasts["error"]["ropo.nro:duplicado"],
                        ],
                    ]);
                }
                $persona->update($basic);
                $persona->setRopoAttribute($r);
            } else {
                $persona->update($basic);
            }

            $persona->save();

            $this->toastExitoConstructor(
                accion: "update",
                seccion: "description",
                append: "{$persona->nombres} {$persona->apellidos} ({$persona->id_nac})"
            );
            return to_route("persona.show", $persona->id)->with([
                "from" => "persona.update",
                "message" => [
                    "toast" => $this->toasts["exito"]["update"],
                ],
            ]);
        }
    }

    public function destroy(Persona $persona)
    {
        //
        $persona->delete();

        $this->toastExitoConstructor(
            accion: "destroy",
            seccion: "description",
            append: "{$persona->nombre} ({$persona->nif})"
        );
        return to_route("persona.index")->with([
            "from" => "persona.destroy",
            "message" => [
                "toast" => $this->toasts["exito"]["destroy"],
            ],
        ]);
    }
}
