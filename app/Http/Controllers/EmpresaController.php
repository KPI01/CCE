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

        foreach ($this->toasts["exito"] as $key => $value) {
            $this->toastExitoConstructor(
                accion: $key,
                seccion: "title",
                append: "Empresa"
            );
        }
    }

    public function index()
    {
        //
        $this->data = Empresa::all();

        return Inertia::render("Recursos/Empresas/Table", [
            "data" => $this->appendUrls(recurso: "empresas", data: $this->data),
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
        } elseif (Empresa::where("nif", $uniques["nif"])->exists()) {
            $this->toastErrorConstructor(
                campo: "nif",
                error: "Duplicado",
                mensaje: implode(" ", [
                    "NIF:",
                    $uniques["nif"],
                    "ya se encuentra registrado",
                ]),
                variante: "warning"
            );
            return redirect()
                ->back()
                ->with([
                    "message" => [
                        "toast" => $this->toasts["error"]["nif:duplicado"],
                    ],
                ]);
        } else {
            $r = $request->input("ropo");

            if (isset($r)) {
                if (
                    DB::table(Empresa::ROPO_TABLE)
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
                $this->inst = Empresa::create($basic)->setRopoAttribute($r);
            } else {
                $this->inst = Empresa::create($basic);
            }

            $this->toastExitoConstructor(
                accion: "store",
                seccion: "description",
                append: $this->inst->nombre . " (" . $this->inst->nif . ")"
            );
            return redirect()
                ->intended(route("empresas.index"))
                ->with([
                    "from" => "empresas.store",
                    "message" => [
                        "toast" => $this->toasts["exito"]["store"],
                    ],
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
                ],
            ],
            "urls" => [
                "edit" => route("empresas.edit", $this->inst->id),
                "destroy" => route("empresas.destroy", $this->inst->id),
            ],
        ]);
    }

    public function edit(string $id)
    {
        //
        $this->inst = Empresa::findOrFail($id);

        return Inertia::render("Recursos/Empresas/Edit", [
            "data" => [
                ...Arr::except($this->inst->toArray(), ["ropo"]),
                "ropo" => [
                    "capacitacion" => $this->inst->ropo["capacitacion"],
                    "nro" => $this->inst->ropo["nro"],
                    "caducidad" => $this->inst->ropo["caducidad"],
                ],
            ],
            "urls" => [
                "show" => route("empresas.show", $this->inst->id),
                "update" => route("empresas.update", $this->inst->id),
            ],
        ]);
    }

    public function update(Request $request, string $id)
    {
        //
        $this->inst = Empresa::findOrFail($id);
        $basic = $request->all();
        unset($basic["ropo"]);
        $uniques = $request->all(["email", "nif"]);

        if (
            Empresa::where([
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
                    "from" => "empresas.update",
                    "message" => [
                        "toast" => $this->toasts["error"]["email:duplicado"],
                    ],
                ]);
        } elseif (
            Empresa::where([
                ["nif", $uniques["nif"]],
                ["id", "<>", $this->inst->id],
            ])->exists()
        ) {
            $this->toastErrorConstructor(
                campo: "nif",
                error: "Duplicado",
                mensaje: implode(" ", [
                    "NIF:",
                    $uniques["nif"],
                    "ya se encuentra registrado",
                ]),
                variante: "warning"
            );
            return redirect()
                ->back()
                ->with([
                    "from" => "empresas.update",
                    "message" => [
                        "toast" => $this->toasts["error"]["id_nac:duplicado"],
                    ],
                ]);
        } else {
            $r = $request->input("ropo");

            if (isset($r)) {
                if (
                    DB::table(Empresa::ROPO_TABLE)
                        ->where("nro", $r["nro"])
                        ->where("empresa_id", "<>", $this->inst->id)
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
                $this->inst->setRopoAttribute($r);
            } else {
                $this->inst->update($basic);
            }

            $this->toastExitoConstructor(
                accion: "update",
                seccion: "description",
                append: implode(" ", [
                    $this->inst->nombre,
                    "(" . $this->inst->nif . ")",
                ])
            );
            return redirect()
                ->intended(route("empresas.index"))
                ->with([
                    "from" => "empresas.update",
                    "message" => [
                        "toast" => $this->toasts["exito"]["update"],
                    ],
                ]);
        }
    }

    public function destroy(Request $req, string $id)
    {
        //
        $this->inst = Empresa::findOrFail($id);
        $this->inst->delete();

        $this->toastExitoConstructor(
            accion: "destroy",
            seccion: "description",
            append: $this->inst->nombre . " (" . $this->inst->nif . ")"
        );
        return redirect()
            ->route("empresas.index")
            ->with([
                "message" => [
                    "toast" => $this->toasts["exito"]["destroy"],
                ],
            ]);
    }
}
