<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyRecursoRequest;
use App\Models\Persona;
use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\StoreRecursoRequest;
use App\Http\Requests\UpdateRecursoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PersonaController extends RecursoController
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
            "data" => $this->indexAll("personas", $this->data),
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

    public function store(StoreRecursoRequest $request)
    {
        //
        $data = $request->all();
        $ropo = [];

        foreach ($data as $key => $value) {
            if (str_contains($key, "ropo")) {
                foreach ($value as $k => $v) {
                    $ropo[$k] = $v;
                }
                unset($data[$key]);
            }
        }

        $ropo = count($ropo) > 0 ? $ropo : null;

        if (Persona::where("email", $data["email"])->exists()) {
            $email = $data["email"];
            return Redirect::back()->withErrors([
                "email" => "[$email] ya existe está registrado.",
            ]);
        } elseif (Persona::where("id_nac", $data["id_nac"])->exists()) {
            $id_nac = $data["id_nac"];
            $tipo_id_nac = $data["tipo_id_nac"];
            return Redirect::back()->withErrors([
                "id_nac" => "[$tipo_id_nac: $id_nac] ya está registrado.",
            ]);
        }

        $this->instance = Persona::create($data);
        $this->instance->save();

        if ($ropo) {
            $ropo_nro = $ropo["nro"];

            if (DB::table("persona_ropo")->where("nro", $ropo_nro)->exists()) {
                return Redirect::back()->withErrors([
                    "ropo.nro" => "[Nro Ropo:$ropo_nro] ya existe está registrado.",
                ]);
            }

            $this->instance->setRopoAttribute($ropo);
        }

        $tipo_id_nac = $this->instance->tipo_id_nac;
        $id_nac = $this->instance->id_nac;

        $this->message = "Persona con $tipo_id_nac $id_nac creada con éxito";

        return Redirect::intended(route("personas.index"))->with([
            "from" => "store.persona",
            "message" => ["content" => $this->message],
        ]);
    }

    public function show(Request $req, string $id)
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

    public function update(UpdateRecursoRequest $request, string $id)
    {
        //
        $aux = $request->all();
        $r = $aux["ropo"];
        $r["caducidad"] = date("Y-m-d", strtotime($r["caducidad"]));
        unset($aux["ropo"]);

        $this->data = Persona::where("id", $id)->update($aux);
        DB::table("persona_ropo")->where("persona_id", $id)->update($r);
        $this->instance = Persona::findOrFail($id);

        return Redirect::intended(route("personas.index"))->with([
            "from" => "update.persona",
            "message" => [
                "action" => [
                    "type" => "update",
                    "data" => $this->instance,
                ],
                "toast" => [
                    "variant" => "default",
                    "title" => "Recurso: Persona",
                    "description" =>
                        $this->instance->nombres .
                        " " .
                        $this->instance->apellidos .
                        " (" .
                        $this->instance->id_nac .
                        ") se ha actualizado de los registros.",
                ],
            ],
        ]);
    }

    public function destroy(DestroyRecursoRequest $req, string $id)
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
