<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

abstract class Controller
{
    //
    protected Authenticatable|null $user;
    protected Model $inst;
    protected Collection|Model $data;
    protected string $msg;
    protected array $toasts = ["exito" => [], "error" => []];
    protected string $tableName;

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
            report("Variante no válida");
        }

        $this->toasts["error"][$key] = [
            "variant" => $variante,
            "title" => "Error: $error",
            "description" => $mensaje,
        ];
    }

    protected function valueExists(
        string $table,
        string $column,
        mixed $value,
        string $operator = "="
    ): bool {
        $field = $column;
        $fieldTitle = match ($column) {
            "email" => "Correo",
            "id_nac" => "DNI/NIE",
            "nif" => "NIF",
            default => ucfirst($column),
        };

        if (str_contains($table, "ropo")) {
            $field = "ropo.$column";
        }

        if (DB::table($table)->where($column, $operator, $value)->exists()) {
            $this->toastErrorConstructor(
                variante: "warning",
                campo: $field,
                error: "Duplicado",
                mensaje: "$fieldTitle [{$value}] ya existe en la base de datos"
            );
            return true;
        }

        return false;
    }
}
