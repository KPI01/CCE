<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Exceptions;

abstract class Controller
{
    //
    protected Authenticatable|null $user;
    protected Model $inst;
    protected Collection|Model $data;
    protected string $msg;
    protected array $toasts = ["exito" => [], "error" => []];

    // Constructor
    public function __construct()
    {
        $this->user = Auth::user();
        $this->toasts["exito"] = [
            "store" => [
                "variant" => "muted",
                "title" => "Sistema:",
                "description" => "se ha registrado exitosamente.",
            ],
            "update" => [
                "variant" => "default",
                "title" => "Sistema:",
                "description" => "se ha editado exitosamente.",
            ],
            "destroy" => [
                "variant" => "destructive",
                "title" => "Sistema:",
                "description" => "se ha eliminado exitosamente.",
            ],
        ];
    }

    protected function toastExitoConstructor(
        string $accion,
        string $seccion,
        string $append
    ) {
        switch ($seccion) {
            case "title":
                $this->toasts["exito"][$accion][$seccion] = implode(" ", [
                    $this->toasts["exito"][$accion][$seccion],
                    $append,
                ]);
                break;

            default:
                $this->toasts["exito"][$accion][$seccion] = implode(" ", [
                    $append,
                    $this->toasts["exito"][$accion][$seccion],
                ]);
                break;
        }
    }

    protected function toastErrorConstructor(
        string $variante,
        string $campo,
        string $error,
        string $mensaje
    ) {
        $variantes = ["warning", "destructive"];
        $errNameAux = strtolower($error);
        $key = "$campo:$errNameAux";

        if (!in_array($variante, $variantes)) {
            throw new Exceptions("Variante no válida");
        }

        $this->toasts["error"][$key] = [
            "variant" => $variante,
            "title" => "Error: $error",
            "description" => $mensaje,
        ];
    }

    protected function appendUrls(
        string $recurso,
        Collection $data
    ): SupportCollection {
        return $data->map(function ($data) use ($recurso) {
            return [
                ...$data->toArray(),
                "urls" => [
                    "edit" => route("$recurso.edit", $data->id),
                    "destroy" => route("$recurso.destroy", $data->id),
                    "show" => route("$recurso.show", $data->id),
                ],
            ];
        });
    }
}
