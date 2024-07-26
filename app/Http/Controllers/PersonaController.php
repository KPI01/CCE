<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PersonaController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        //
        $this->data = Persona::all();

        return Inertia::render("Recursos/Personas/Table", [
            "data" => $this->appendUrls("personas", $this->data),
        ]);
    }

    public function create()
    {
        //
        return Inertia::render("Recursos/Personas/Create", [
            "urls" => [
                "store" => route("personas.store"),
                "index" => route("personas.index"),
            ],
        ]);
    }

    public function store(Request $request)
    {
        //
        $basic = $request->all();
        unset($basic["ropo"]);
        $uniques = $request->all(["email", "id_nac"]);

        if (Persona::where("email", $uniques["email"])->exists()) {
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
            return redirect()
                ->back()
                ->with([
                    "from" => "personas.store",
                    "message" => [
                        "toast" => $this->toasts["error"]["email:duplicado"],
                    ],
                ]);
        } elseif (Persona::where("id_nac", $uniques["id_nac"])->exists()) {
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
            return redirect()
                ->back()
                ->with([
                    "from" => "personas.store",
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
                    return redirect()
                        ->back()
                        ->with([
                            "from" => "personas.store",
                            "message" => [
                                "toast" =>
                                    $this->toasts["error"][
                                        "ropo.nro:duplicado"
                                    ],
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
            return redirect()
                ->intended(route("personas.index"))
                ->with([
                    "from" => "personas.store",
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

        return Inertia::render("Recursos/Personas/Show", [
            "data" => [
                ...Arr::except($this->data->toArray(), [
                    "created_at",
                    "updated_at",
                ]),
                "created_at" => $this->data->created_at->format("Y-m-d H:i:s"),
                "updated_at" => $this->data->updated_at->format("Y-m-d H:i:s"),
            ],
            "urls" => [
                "index" => route("personas.index"),
                "edit" => route("personas.edit", $this->data->id),
                "destroy" => route("personas.destroy", $this->data->id),
            ],
        ]);
    }

    public function edit(string $id)
    {
        //
        $this->inst = Persona::findOrFail($id);

        return Inertia::render("Recursos/Personas/Edit", [
            "data" => [
                ...Arr::except($this->inst->toArray(), [
                    "created_at",
                    "updated_at",
                ]),
                "created_at" => $this->inst->created_at->format("Y-m-d H:i:s"),
                "updated_at" => $this->inst->updated_at->format("Y-m-d H:i:s"),
            ],
            "urls" => [
                "update" => route("personas.update", $this->inst->id),
                "show" => route("personas.show", $this->inst->id),
            ],
        ]);
    }

    public function update(Request $request, string $id)
    {
        //
        $this->inst = Persona::findOrFail($id);
        $basic = $request->all();
        unset($basic["ropo"]);
        $uniques = $request->all(["email", "id_nac"]);

        if (
            Persona::where([
                ["email", $uniques["email"]],
                ["id", "<>", $this->inst->id],
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
            return redirect()
                ->back()
                ->with([
                    "from" => "personas.update",
                    "message" => [
                        "toast" => $this->toasts["error"]["email:duplicado"],
                    ],
                ]);
        } elseif (
            Persona::where([
                ["id_nac", $uniques["id_nac"]],
                ["id", "<>", $this->inst->id],
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
            return redirect()
                ->back()
                ->with([
                    "from" => "personas.update",
                    "message" => [
                        "toast" => $this->toasts["error"]["id_nac:duplicado"],
                    ],
                ]);
        } else {
            $r = $request->input("ropo");
            // dd($r);

            if (isset($r)) {
                // dd('La variable $r existe');
                if (
                    DB::table(Persona::ROPO_TABLE)
                        ->where("nro", $r["nro"])
                        ->where("persona_id", "<>", $this->inst->id)
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
                    return redirect()
                        ->back()
                        ->with([
                            "from" => "personas.update",
                            "message" => [
                                "toast" =>
                                    $this->toasts["error"][
                                        "ropo.nro:duplicado"
                                    ],
                            ],
                        ]);
                }
                $this->inst->update($basic);
                // dd('Antes de usar setRopoAttribute($r) -> $r:', $r);
                $this->inst->setRopoAttribute($r);
            } else {
                $this->inst->update($basic);
            }

            $this->inst->save();

            $this->toastExitoConstructor(
                accion: "update",
                seccion: "description",
                append: implode(" ", [
                    $this->inst->nombres,
                    $this->inst->apellidos,
                    "(" . $this->inst->id_nac . ")",
                ])
            );
            return redirect()
                ->intended(route("personas.index"))
                ->with([
                    "from" => "personas.update",
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

        return Redirect::intended(route("personas.index"))->with([
            "from" => "destroy.persona",
            "message" => [
                "action" => [
                    "type" => "destroy",
                    "data" => $this->data,
                ],
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
