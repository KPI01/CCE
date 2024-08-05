<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use Illuminate\Http\Request;

class MaquinaController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->tableName = (new Maquina())->getTable();

        foreach ($this->toasts["exito"] as $key => $value) {
            $this->toastExitoConstructor(
                accion: $key,
                seccion: "title",
                append: "Máquina"
            );
        }
    }

    public function index()
    {
        //
        $this->data = Maquina::all();
        return inertia("Recursos/Maquinas/Table", [
            "data" => $this->data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Maquina $maquina)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maquina $maquina)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Maquina $maquina)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $this->data = Maquina::findOrFail($id);
        $this->data->delete();
        return to_route("maquina.index")->with([
            "from" => "maquina.destroy",
            "message" => [
                "toast" => [
                    "variant" => "destructive",
                    "title" => "Recurso: Máquina",
                    "description" => implode([
                        $this->data->nombre,
                        " ",
                        "({$this->data->matricula})",
                        " ",
                        "se ha eliminado de los registros.",
                    ]),
                ],
            ],
        ]);
    }
}
