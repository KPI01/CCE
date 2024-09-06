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

        $this->tableName = (new Empresa())->getTable();

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
        $data = Empresa::all();

        return inertia("Recursos/Empresa/Table", [
            "data" => $data,
            "url" => route("empresa.index"),
        ]);
    }

    public function create()
    {
        //
        return inertia("Recursos/Empresa/Create", [
            "url" => route("empresa.index"),
        ]);
    }

    public function store(Request $request)
    {
        //
        $basic = $request->all();
        unset($basic["ropo"]);
        $uniques = $request->all(["email", "nif"]);

        if (
            $this->valueExists(
                table: $this->tableName,
                column: "email",
                value: $uniques["email"]
            )
        ) {
            return to_route("empresa.index")->with([
                "from" => "empresa.store",
                "message" => [
                    "toast" => $this->toasts["error"]["email:duplicado"],
                ],
            ]);
        } elseif (
            $this->valueExists(
                table: $this->tableName,
                column: "nif",
                value: $uniques["nif"]
            )
        ) {
            return to_route("empresa.index")->with([
                "from" => "empresa.store",
                "message" => [
                    "toast" => $this->toasts["error"]["nif:duplicado"],
                ],
            ]);
        } else {
            $r = $request->input("ropo");

            if (isset($r)) {
                if (
                    $this->valueExists(
                        table: Empresa::ROPO_TABLE,
                        column: "nro",
                        value: $r["nro"]
                    )
                ) {
                    return to_route("empresa.index")->with([
                        "from" => "empresa.store",
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
                append: "{$this->inst->nombre} ({$this->inst->nif})"
            );
            return to_route("empresa.index")->with([
                "from" => "empresa.store",
                "message" => [
                    "toast" => $this->toasts["exito"]["store"],
                ],
            ]);
        }
    }

    public function show(Empresa $empresa)
    {
        //
        return inertia("Recursos/Empresa/Show", [
            "data" => $empresa,
        ]);
    }

    public function edit(Empresa $empresa)
    {
        //
        return inertia("Recursos/Empresa/Edit", [
            "data" => $empresa,
        ]);
    }

    public function update(Request $request, Empresa $empresa)
    {
        //
        $basic = $request->all();
        unset($basic["ropo"]);
        $uniques = $request->all(["email", "nif"]);

        if (
            Empresa::where([
                ["email", $uniques["email"]],
                ["id", "<>", $empresa->id],
            ])->exists()
        ) {
            $this->toastErrorConstructor(
                campo: "email",
                error: "Duplicado",
                mensaje: "Correo: {$uniques["email"]} ya se encuentra registrado",
                variante: "warning"
            );
            return to_route("empresa.edit", $empresa->id)->with([
                "from" => "empresa.update",
                "message" => [
                    "toast" => $this->toasts["error"]["email:duplicado"],
                ],
            ]);
        } elseif (
            Empresa::where([
                ["nif", $uniques["nif"]],
                ["id", "<>", $empresa->id],
            ])->exists()
        ) {
            $this->toastErrorConstructor(
                campo: "nif",
                error: "Duplicado",
                mensaje: "NIF: {$uniques["nif"]} ya se encuentra registrado",
                variante: "warning"
            );
            return to_route("empresa.edit", $empresa->id)->with([
                "from" => "empresa.update",
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
                        ->where("empresa_id", "<>", $empresa->id)
                        ->exists()
                ) {
                    $this->toastErrorConstructor(
                        campo: "ropo.nro",
                        error: "Duplicado",
                        mensaje: "Nº ROPO: {$r["nro"]} ya se encuentra registrado",
                        variante: "warning"
                    );
                    return to_route("empresa.edit", $empresa->id)->with([
                        "from" => "empresa.update",
                        "message" => [
                            "toast" =>
                                $this->toasts["error"]["ropo.nro:duplicado"],
                        ],
                    ]);
                }
                $empresa->update($basic);
                $empresa->setRopoAttribute($r);
            } else {
                $empresa->update($basic);
            }

            $this->toastExitoConstructor(
                accion: "update",
                seccion: "description",
                append: "{$empresa->nombre} ({$empresa->nif})"
            );
            return to_route("empresa.show", $empresa->id)->with([
                "from" => "empresa.update",
                "message" => [
                    "toast" => $this->toasts["exito"]["update"],
                ],
            ]);
        }
    }

    public function destroy(Empresa $empresa)
    {
        //
        $empresa->delete();

        $this->toastExitoConstructor(
            accion: "destroy",
            seccion: "description",
            append: "{$empresa->nombre} ({$empresa->nif})"
        );
        return to_route("empresa.index")->with([
            "from" => "empresa.destroy",
            "message" => [
                "toast" => $this->toasts["exito"]["destroy"],
            ],
        ]);
    }
}
