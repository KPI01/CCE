<?php

namespace App\Http\Controllers;

use App\Models\Cultivo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\ResponseTrait;
use Illuminate\Support\Arr;

class CultivoController extends Controller
{
    use ResponseTrait;

    public function index(): JsonResponse
    {
        //
        $data = Cultivo::all()->toArray();
        return response()->json(data: $data);
    }

    public function store(Request $request): JsonResponse
    {
        //
        $data = [
            "nombre" => $request->query(key: "nombre"),
            "variedad" => $request->query(key: "variedad"),
        ];

        if (
            is_null(value: $data["nombre"]) or is_null(value: $data["variedad"])
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

        Cultivo::create($data);

        return response()->json(
            data: [
                "status" => 200,
                "mensaje" => "Cultivo creado exitosamente.",
                "payload" => $data,
            ]
        );
    }

    public function update(Request $request, Cultivo $cultivo)
    {
        //
        $data = [
            "nombre" => $request->query(key: "nombre"),
            "variedad" => $request->query(key: "variedad"),
        ];

        if (
            is_null(value: $data["nombre"]) or is_null(value: $data["variedad"])
        ) {
            return response()->json(
                data: [
                    "status" => 400,
                    "mensaje" => "No se han encontrado los datos necesarios.",
                    "payload" => [
                        "original" => $cultivo->getAttributes(),
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
                    "status" => 409,
                    "mensaje" =>
                        "No se encontraron los datos para actualizar el cultivo.",
                    "payload" => [
                        "original" => $cultivo->getAttributes(),
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
        } elseif (
            Cultivo::where([
                ["nombre", "=", $cultivo->nombre],
                ["variedad", "=", $data["variedad"]],
            ])->exists() and
            Cultivo::where([
                ["nombre", "=", $data["nombre"]],
                ["variedad", "=", $cultivo->variedad],
            ])->exists()
        ) {
            return response()->json(
                data: [
                    "status" => 409,
                    "mensaje" =>
                        "Ya existe un cultivo con ese nombre y variedad.",
                    "payload" => [
                        "original" => $cultivo->getAttributes(),
                        "sent" => $data,
                    ],
                ],
                status: 409
            );
        }

        $cultivo->update($data);

        return response()->json(
            data: [
                "status" => 200,
                "mensaje" => "El cultivo ha sido actualizado exitosamente.",
                "payload" => $cultivo->toArray(),
            ]
        );
    }

    public function destroy(Cultivo $cultivo)
    {
        //
        return response()->json(data: $cultivo);
        if ($cultivo->exists()) {
            $cultivo->delete();
            return response()->json(
                data: [
                    "status" => 204,
                    "mensaje" => "El cultivo ha sido eliminado exitosamente.",
                ]
            );
        } else {
            return response()->json(
                data: [
                    "status" => 404,
                    "mensaje" =>
                        "No se encontró el cultivo que desea eliminar.",
                ]
            );
        }
    }
}
