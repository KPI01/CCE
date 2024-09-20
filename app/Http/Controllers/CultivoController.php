<?php

namespace App\Http\Controllers;

use App\Models\Cultivo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CultivoController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->tableName = (new Cultivo())->getTable();

        foreach ($this->toasts["exito"] as $key => $value) {
            $this->toastExitoConstructor(
                accion: $key,
                seccion: "title",
                append: "Cultivo"
            );
        }
    }
    public function index()
    {
        $data = Cultivo::all();
        return inertia("Config/Auxiliares/Recursos/Cultivo", [
            "rows" => $data,
            "url" => route("cultivo.index"),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "nombre" => ["required", "string"],
            "variedad" => ["nullable", "string"],
        ]);

        if (!isset($data["variedad"])) {
            $data["variedad"] = null;
        }

        if (
            Cultivo::where([
                ["nombre", "=", $data["nombre"]],
                ["variedad", "=", $data["variedad"]],
            ])->exists()
        ) {
            $this->toastErrorConstructor(
                campo: "cultivo",
                error: "Duplicidad",
                mensaje: "Ya existe un cultivo con dicho nombre y variedad",
                variante: "warning"
            );

            return to_route("cultivo.index")->with([
                "from" => "cultivo.store",
                "message" => [
                    "toast" => $this->toasts["error"]["cultivo:duplicidad"],
                ],
            ]);
        }

        Cultivo::create($data);

        $name = !is_null($data["variedad"])
            ? "{$data["nombre"]} {$data["variedad"]}"
            : $data["nombre"];
        $this->toastExitoConstructor(
            accion: "store",
            seccion: "description",
            append: "El cultivo {$name} se ha creado exitosamente"
        );
        return to_route("cultivo.index")->with([
            "from" => "cultivo.store",
            "message" => [
                "toast" => $this->toasts["exito"]["store"],
            ],
        ]);
    }

    public function edit()
    {
    }
    public function update()
    {
    }
    public function destroy()
    {
    }

    public function apiIndex(Request $request): JsonResponse
    {
        //
        if (is_null($request->query(key: "id"))) {
            return response()->json(data: Cultivo::all(), status: 200);
        } else {
            $cultivo = Cultivo::findOrFail($request->query(key: "id"));

            return response()->json(data: $cultivo, status: 200);
        }
    }

    public function apiStore(Request $request): JsonResponse
    {
        //
        $data = [
            "nombre" => $request->query(key: "nombre"),
            "variedad" => $request->query(key: "variedad"),
        ];

        if (
            is_null(value: $data["nombre"]) and
            is_null(value: $data["variedad"])
        ) {
            return response()->json(
                data: [
                    "status" => 400,
                    "mensaje" => "No se han encontrado los datos necesarios.",
                    "payload" => $data,
                ],
                status: 400
            );
        } elseif (
            Cultivo::where([
                ["nombre", "=", $data["nombre"]],
                ["variedad", "=", $data["variedad"]],
            ])->exists()
        ) {
            return response()->json(
                data: [
                    "status" => 409,
                    "mensaje" =>
                        "Ya existe un cultivo con ese nombre y variedad.",
                    "payload" => $data,
                ],
                status: 409
            );
        }

        $inst = Cultivo::create($data);

        return response()->json(data: $inst, status: 201);
    }

    public function apiUpdate(Request $request, Cultivo $cultivo): JsonResponse
    {
        //
        $data = [
            "nombre" => $request->query(key: "nombre"),
            "variedad" => $request->query(key: "variedad"),
        ];

        if (
            is_null(value: $data["nombre"]) and
            is_null(value: $data["variedad"])
        ) {
            return response()->json(
                data: [
                    "mensaje" => "No se han encontrado los datos necesarios.",
                    "payload" => [
                        "sent" => $data,
                    ],
                ],
                status: 400
            );
        } elseif (
            in_array(needle: $data, haystack: $cultivo->getAttributes())
        ) {
            return response()->json(
                data: [
                    "payload" => [
                        "original" => $cultivo,
                        "sent" => $data,
                    ],
                    "result" => array_diff(
                        Arr::only(
                            array: $cultivo->getAttributes(),
                            keys: ["nombre", "variedad"]
                        ),
                        $data
                    ),
                ],
                status: 409
            );
        }

        $cultivo->update($data);

        return response()->json(data: $cultivo->toArray(), status: 200);
    }

    public function apiDestroy(Cultivo $cultivo)
    {
        //
        $cultivo->delete();

        return response(status: 204);
    }
}
