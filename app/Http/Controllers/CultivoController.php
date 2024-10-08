<?php

namespace App\Http\Controllers;

use App\Models\Cultivo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

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
        $attrs = array_keys(Cultivo::first()->getAttributes());
        $fields = [];
        $url = route("cultivo.index");

        foreach ($attrs as $attr) {
            $type = Schema::getColumnType($this->tableName, $attr);
            $fields[$attr] = $type;
        }
        for ($i = 0; $i < count($fields); $i++) {
            unset($fields[$i]);
        }

        return inertia(
            "Config/Auxiliares/Recursos/Cultivo",
            compact("data", "fields", "url")
        );
    }

    public function store(Request $request)
    {
        $data = $request->input();

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

    public function update(Request $request, Cultivo $cultivo)
    {
        $data = $request->input();

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
                "from" => "cultivo.update",
                "message" => [
                    "toast" => $this->toasts["error"]["cultivo:duplicidad"],
                ],
            ]);
        }
        $cultivo->update($data);

        $this->toastExitoConstructor(
            accion: "update",
            seccion: "description",
            append: "El cultivo " .
                $data["nombre"] .
                " se ha actualizado exitosamente"
        );
        return to_route("cultivo.index")->with([
            "from" => "cultivo.update",
            "message" => [
                "toast" => $this->toasts["exito"]["update"],
            ],
        ]);
    }
    public function destroy(Request $request, Cultivo $cultivo)
    {
        $cultivo->delete();
        $this->toastExitoConstructor(
            accion: "destroy",
            seccion: "description",
            append: "El cultivo {$cultivo->nombre} se ha eliminado exitosamente"
        );
        return to_route("cultivo.index")->with([
            "from" => "cultivo.destroy",
            "message" => [
                "toast" => $this->toasts["exito"]["destroy"],
            ],
        ]);
    }
}
