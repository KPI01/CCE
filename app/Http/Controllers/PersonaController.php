<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
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
                    "message" => [
                        "toast" => $this->toasts["error"]["id_nac:duplicado"],
                    ],
                ]);
        } else {
            $r = $request->input("ropo");

            if (isset($r)) {
                if (
                    DB::table("empresa_ropo")
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
                ...$this->data->toArray(),
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
        $this->data = Persona::findOrFail($id);

        return Inertia::render("Recursos/Personas/Edit", [
            "data" => [
                ...$this->data->only([
                    "id",
                    "nombres",
                    "apellidos",
                    "tipo_id_nac",
                    "id_nac",
                    "email",
                    "tel",
                    "perfil",
                    "observaciones",
                    "ropo",
                ]),
                "created_at" => $this->data->created_at->format("Y-m-d H:i:s"),
                "updated_at" => $this->data->updated_at->format("Y-m-d H:i:s"),
            ],
            "urls" => [
                "update" => route("personas.update", $this->data->id),
                "show" => route("personas.show", $this->data->id),
            ],
        ]);
    }

    public function update(Request $request, string $id)
    {
        //
        $aux = $request->all();
        $r = $aux["ropo"];
        $r["caducidad"] = date("Y-m-d", strtotime($r["caducidad"]));
        unset($aux["ropo"]);

        $this->data = Persona::where("id", $id);
        $this->data->update($aux);
        DB::table("persona_ropo")->where("persona_id", $id)->update($r);
        $this->inst = Persona::findOrFail($id);

        return Redirect::intended(route("personas.index"))->with([
            "from" => "update.persona",
            "message" => [
                "action" => [
                    "type" => "update",
                    "data" => $this->inst,
                ],
                "toast" => [
                    "variant" => "default",
                    "title" => "Recurso: Persona",
                    "description" =>
                        $this->inst->nombres .
                        " " .
                        $this->inst->apellidos .
                        " (" .
                        $this->inst->id_nac .
                        ") se ha actualizado de los registros.",
                ],
            ],
        ]);
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
