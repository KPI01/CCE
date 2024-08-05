<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return inertia("Recursos/Empresas/Table", [
            "data" => $this->data,
        ]);
    }

    public function create()
    {
        //

        return inertia("Recursos/Empresas/Create", [
            "urls" => [
                "store" => route("empresas.store"),
                "index" => route("empresas.index"),
                "create" => route("empresas.create"),
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
            return to_route("empresas.index")->with([
                "from" => "empresas.store",
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
            return to_route("empresas.index")->with([
                "from" => "empresas.store",
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
                    return to_route("empresas.index")->with([
                        "from" => "empresas.store",
                        "message" => [
                            "toast" =>
                                $this->toasts["error"]["ropo.nro:duplicado"],
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
            return to_route("empresas.index")->with([
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
        $this->data = Empresa::findOrFail($id);

        return inertia("Recursos/Empresas/Show", [
            "data" => $this->data,
        ]);
    }

    public function edit(string $id)
    {
        //
        $this->data = Empresa::findOrFail($id);

        return inertia("Recursos/Empresas/Edit", [
            "data" => $this->data,
        ]);
    }

    public function update(Request $request, string $id)
    {
        //
        $this->data = Empresa::findOrFail($id);
        $basic = $request->all();
        unset($basic["ropo"]);
        $uniques = $request->all(["email", "nif"]);

        if (
            Empresa::where([
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
            return to_route("empresas.edit", $this->data->id)->with([
                "from" => "empresas.update",
                "message" => [
                    "toast" => $this->toasts["error"]["email:duplicado"],
                ],
            ]);
        } elseif (
            Empresa::where([
                ["nif", $uniques["nif"]],
                ["id", "<>", $this->data->id],
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
            return to_route("empresas.edit", $this->data->id)->with([
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
                        ->where("empresa_id", "<>", $this->data->id)
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
                    return to_route("empresas.edit", $this->data->id)->with([
                        "from" => "empresas.update",
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

            $this->toastExitoConstructor(
                accion: "update",
                seccion: "description",
                append: implode(" ", [
                    $this->data->nombre,
                    "(" . $this->data->nif . ")",
                ])
            );
            return to_route("empresas.index")->with([
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
        $this->data = Empresa::findOrFail($id);
        $this->data->delete();

        $this->toastExitoConstructor(
            accion: "destroy",
            seccion: "description",
            append: $this->data->nombre . " (" . $this->data->nif . ")"
        );
        return to_route("empresas.index")->with([
            "from" => "empresas.destroy",
            "message" => [
                "toast" => $this->toasts["exito"]["destroy"],
            ],
        ]);
    }
}
