<?php

namespace App\Http\Controllers;

use App\Models\Campana;
use Illuminate\Http\Request;

class CampanaController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->tableName = (new Campana())->getTable();

        foreach ($this->toasts["exito"] as $key => $value) {
            $this->toastExitoConstructor(
                accion: $key,
                seccion: "title",
                append: "Campaña"
            );
        }
    }

    public function index()
    {
        //
        $data = Campana::all();
        return inertia("Recursos/Campana/Table", [
            "data" => $data,
            "url" => route("campana.index"),
        ]);
    }

    public function create()
    {
        //
        return inertia("Recursos/Campana/Create", [
            "url" => route("campana.index"),
        ]);
    }

    public function store(Request $request)
    {
        //
        $data = $request->all();
        $inst = Campana::create($data);

        if (
            Campana::where(["nombre", "inicio", "fin"], "=", [
                $data["nombre"],
                $data["inicio"],
                $data["fin"],
            ])->exists()
        ) {
            $this->toastErrorConstructor(
                campo: "campaña",
                error: "Duplicidad",
                mensaje: "Ya existe una campaña con ese nombre, inicio y fin",
                variante: "warning"
            );

            return to_route("campana.index")->with([
                "from" => "campana.store",
                "message" => [
                    "toast" => $this->toasts["error"]["campaña:duplicidad"],
                ],
            ]);
        }

        $this->toastExitoConstructor(
            accion: "store",
            seccion: "description",
            append: "{$inst->nombre} desde {$inst->inicio} a {$inst->fin}"
        );
        return to_route("campana.index")->with([
            "from" => "campana.store",
            "message" => ["toast" => $this->toasts["exito"]["store"]],
        ]);
    }

    public function show(Campana $campana)
    {
        //
        return inertia("Recursos/Campana/Show", [
            "data" => $campana,
        ]);
    }

    public function edit(Campana $campana)
    {
        //
        return inertia("Recursos/Campana/Edit", ["data" => $campana]);
    }

    public function update(Request $request, Campana $campana)
    {
        //
        $data = $request->all();

        if (
            Campana::where(["id", "!=", $campana->id])
                ->where(["nombre", "inicio", "fin"], "=", [
                    $data["nombre"],
                    $data["inicio"],
                    $data["fin"],
                ])
                ->exists()
        ) {
            $this->toastErrorConstructor(
                campo: "campaña",
                error: "Duplicidad",
                mensaje: "Ya existe una campaña con ese nombre, inicio y fin",
                variante: "warning"
            );

            return to_route("campana.show", ["campana" => $campana])->with([
                "from" => "campana.store",
                "message" => [
                    "toast" => $this->toasts["error"]["campaña:duplicidad"],
                ],
            ]);
        }

        $campana->update($data);
        $campana->save();

        $this->toastExitoConstructor(
            accion: "update",
            seccion: "description",
            append: $campana->nombre
        );
        return to_route("campana.show", ["campana" => $campana->id])->with([
            "from" => "campana.update",
            "message" => ["toast" => $this->toasts["exito"]["update"]],
        ]);
    }

    public function destroy(Campana $campana)
    {
        //
        $campana->delete();

        $this->toastExitoConstructor(
            accion: "destroy",
            seccion: "description",
            append: $campana->nombre
        );

        return to_route("campana.index")->with([
            "from" => "campana.destroy",
            "message" => ["toast" => $this->toasts["exito"]["destroy"]],
        ]);
    }
}
