<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EmpresaController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        //
        $this->data = Empresa::all();

        return Inertia::render("Recursos/Empresas/Table", [
            "data" => $this->indexAll("empresas", $this->data),
        ]);
    }

    public function create()
    {
        //

        return Inertia::render("Recursos/Empresas/Create", [
            "urls" => [
                "store" => route("empresas.store"),
                "index" => route("empresas.index"),
            ],
        ]);
    }

    public function store(Request $request)
    {
        //
        $basic = $request->all();
        unset($basic["ropo"]);
        $uniques = $request->all(["email", "nif"]);

        if (Empresa::where("email", $uniques["email"])->exists()) {
            $this->msg = $uniques["email"] . " ya se encuentra registrado";

            return redirect()->back()->with([
                "message" => [
                    "toast" => [
                        "variant" => "warning",
                        "title" => "Correo Duplicado!",
                        "description" => $this->msg
                    ]
                ]
            ]);
        } else if (Empresa::where("nif", $uniques["nif"])->exists()) {
            $this->msg = $uniques["nif"] . " ya se encuentra registrado";

            return redirect()->back()->with([
                "message" => [
                    "toast" => [
                        "variant" => "warning",
                        "title" => "NIF Duplicado!",
                        "description" => $this->msg
                    ]
                ]
            ]);
        } else {
            $r = $request->input("ropo");

            if (isset($r)) {
                if (DB::table("empresa_ropo")->where("nro", $r["nro"])->exists()) {
                    $this->msg = $r["nro"] . " ya se encuentra registrado";
                    return redirect()->back()->with([
                        "message" => [
                            "toast" => [
                                "variant" => "warning",
                                "title" => "Nº ROPO Duplicado!",
                                "description" => $this->msg
                            ]
                        ]
                    ]);
                }
                Empresa::create($basic)->setRopoAttribute($r);
            } else {
                Empresa::create($basic);
            }


            return redirect()->intended(route("empresas.index"))->with([
                "from" => "empresas.store",
                "message" => [
                    "toast" => [
                        "variant" => "default",
                        "title" => "Empresa: Registro Exitoso!"
                    ]
                ]
            ]);
        }
    }

    public function show(string $id)
    {
        //
        $this->inst = Empresa::findOrFail($id);

        return Inertia::render("Recursos/Empresas/Show", [
            "data" => [
                ...Arr::except($this->inst->toArray(), ["ropo"]),
                "ropo" => [
                    "capacitacion" => $this->inst->ropo["capacitacion"],
                    "nro" => $this->inst->ropo["nro"],
                    "caducidad" => $this->inst->ropo["caducidad"],
                ]
            ],
            "urls" => [
                "edit" => route("empresas.edit", $this->inst->id),
                "destroy" => route("empresas.destroy", $this->inst->id),
                "index" => route("empresas.index"),
            ],
        ]);
    }

    public function edit(string $id)
    {
        //
        $this->inst = Empresa::findOrFail($id)->first();

        return Inertia::render("Recursos/Empresas/Edit", [
            "data" => [
                ...Arr::except($this->inst->toArray(), ["ropo"]),
                "ropo" => [
                    "capacitacion" => $this->inst->ropo["capacitacion"],
                    "nro" => $this->inst->ropo["nro"],
                    "caducidad" => $this->inst->ropo["caducidad"],
                ]
            ],
            "urls" => [
                "show" => route("empresas.show", $this->inst->id),
                "update" => route("empresas.update", $this->inst->id),
            ]
        ]);
    }

    public function update(Request $req, string $id)
    {
        //
        $values = $req->all();

        $rValues = null;
        if (array_key_exists("ropo", $values) && isset($values["ropo"])) {
            $rValues = $values["ropo"];
            if (isset($rValues["caducidad"])) {
                $rValues["caducidad"] = date("Y-m-d", strtotime($rValues["caducidad"]));
            }
            unset($values["ropo"]);
        }

        $this->inst = Empresa::findOrFail($id);
        $this->inst->update($values);
        if (isset($rValues)) $this->inst->setRopoAttribute($rValues);

        $this->msg = $this->inst->nombre . "(" . $this->inst->nif . ") ha sido actualizado correctamente!";
        return redirect()->route("empresas.show", $this->inst->id)->with([
            "message" => [
                "toast" => [
                    "variant" => "default",
                    "title" => "Empresa: Actualización",
                    "description" => $this->msg
                ]
            ]
        ]);
    }

    public function destroy(Request $req, string $id)
    {
        //
    }
}
