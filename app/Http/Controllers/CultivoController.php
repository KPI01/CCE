<?php

namespace App\Http\Controllers;

use App\Http\Resources\CultivoResource;
use App\Models\Cultivo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CultivoController extends Controller
{
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
                    "status" => 400,
                    "mensaje" => "No se han encontrado los datos necesarios.",
                    "payload" => [
                        "original" => $cultivo,
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

        return response()->json(
            data: [
                "payload" => $cultivo,
            ]
        );
    }

    public function apiDestroy(Cultivo $cultivo): JsonResponse
    {
        //
        $cultivo->delete();

        return response()->json(
            data: [
                "mensaje" => "El cultivo ha sido eliminado.",
                "payload" => $cultivo,
            ],
            status: 200
        );
    }
}
