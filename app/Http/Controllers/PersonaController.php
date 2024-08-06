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
        $this->data = Persona::all();

        return inertia("Recursos/Personas/Table", [
            "data" => $this->data,
        ]);
    }

    public function create()
    {
        //
        return inertia("Recursos/Personas/Create", [
            "urls" => [
                "store" => route("persona.store"),
                "index" => route("persona.index"),
                "create" => route("persona.create"),
            ],
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
                $this->inst = Persona::create($basic)->setRopoAttribute($r);
            } else {
                $this->inst = Persona::create($basic);
            }
            $this->toastExitoConstructor(
                accion: "store",
                seccion: "description",
                append: implode(" ", [
                    $this->inst->nombres,
                    $this->inst->apellidos,
                    "(" . $this->inst->id_nac . ")",
                ])
            );
            return to_route("persona.index")->with([
                "from" => "persona.store",
                "message" => [
                    "toast" => $this->toasts["exito"]["store"],
                ],
            ]);
        }
    }

    public function show(string $id)
    {
        //
        $this->data = Persona::findOrFail($id);

        return inertia("Recursos/Personas/Show", [
            "data" => $this->data,
        ]);
    }

    public function edit(string $id)
    {
        //
        $this->data = Persona::findOrFail($id);

        return inertia("Recursos/Personas/Edit", [
            "data" => $this->data,
        ]);
    }

    public function update(Request $request, string $id)
    {
        //
        $this->data = Persona::findOrFail($id);
        $basic = $request->all();
        unset($basic["ropo"]);
        $uniques = $request->all(["email", "id_nac"]);

        if (
            Persona::where([
                ["email", $uniques["email"]],
                ["id", "<>", $this->data->id],
            ])->exists()
        ) {
            $this->toastErrorConstructor(
                campo: "email",
                error: "Duplicado",
                mensaje: implode(" ", [
                    "Correo:",
                    $uniques["email"],
                    "ya se encuentra registrado",
                ]),
                variante: "warning"
            );
            return to_route("persona.edit", $this->data->id)->with([
                "from" => "persona.update",
                "message" => [
                    "toast" => $this->toasts["error"]["email:duplicado"],
                ],
            ]);
        } elseif (
            Persona::where([
                ["id_nac", $uniques["id_nac"]],
                ["id", "<>", $this->data->id],
            ])->exists()
        ) {
            $this->toastErrorConstructor(
                campo: "id_nac",
                error: "Duplicado",
                mensaje: implode(" ", [
                    "NIF:",
                    $uniques["id_nac"],
                    "ya se encuentra registrado",
                ]),
                variante: "warning"
            );
            return to_route("persona.edit", $this->data->id)->with([
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
                        ->where("persona_id", "<>", $this->data->id)
                        ->exists()
                ) {
                    $this->toastErrorConstructor(
                        campo: "ropo.nro",
                        error: "Duplicado",
                        mensaje: implode(" ", [
                            "Nº ROPO:",
                            $r["nro"],
                            "ya se encuentra registrado",
                        ]),
                        variante: "warning"
                    );
                    return to_route("persona.edit", $this->data->id)->with([
                        "from" => "persona.update",
                        "message" => [
                            "toast" =>
                                $this->toasts["error"]["ropo.nro:duplicado"],
                        ],
                    ]);
                }
                $this->data->update($basic);
                $this->data->setRopoAttribute($r);
            } else {
                $this->data->update($basic);
            }

            $this->data->save();

            $this->toastExitoConstructor(
                accion: "update",
                seccion: "description",
                append: implode(" ", [
                    $this->data->nombres,
                    $this->data->apellidos,
                    "(" . $this->data->id_nac . ")",
                ])
            );
            return to_route("persona.show", $this->data->id)->with([
                "from" => "persona.update",
                "message" => [
                    "toast" => $this->toasts["exito"]["update"],
                ],
            ]);
        }
    }

    public function destroy(string $id)
    {
        //
        $this->data = Persona::findOrFail($id);
        $this->data->delete();

        return to_route("persona.index")->with([
            "from" => "persona.destroy",
            "message" => [
                "toast" => [
                    "variant" => "destructive",
                    "title" => "Recurso: Persona",
                    "description" =>
                        $this->data->nombres .
                        " " .
                        $this->data->apellidos .
                        " (" .
                        $this->data->id_nac .
                        ") se ha eliminado de los registros.",
                ],
            ],
        ]);
    }
}
