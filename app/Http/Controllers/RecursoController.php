<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyRecursoRequest;
use App\Http\Requests\StoreRecursoRequest;
use App\Http\Requests\UpdateRecursoRequest;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecursoController extends Controller
{
    
    // Variable para almacenar datos recuperados de la BD o request
    public $data;
    // Variable para guardar las relaciones del modelo
    public $relations;
    // Variable para el rol de administrador
    public $adm_role;
    // Variable para el usuario
    public $user;
    // Variable para instancia de modelo
    public $instance;
    // Variable para devolver mensajes al usuario
    public $message;

    public function __construct()
    {
        $this->adm_role = Role::where('name', 'Admin')->first()->id;
        $this->user = Auth::user();
    }

    protected function indexAll(string $recurso, Collection $data)
    {
        return $data->map(function ($data) use ($recurso) {
            return [
                ...$data->toArray(),
                'urls' => [
                    'edit' => route("$recurso.edit", $data->id),
                    'destroy' => route("$recurso.destroy", $data->id),
                    'show' => route("$recurso.show", $data->id),
                ]
            ];
        });
    }

    /**
     * Enviar todos los datos hacia la vista principal.
     */
    public function index()
    {
        //
    }

    /**
     * Mostrar el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        //
    }

    /**
     * Almacenar un nuevo recurso en la base de datos.
     */
    public function store(StoreRecursoRequest $req)
    {
        //
    }

    /**
     * Mostrar un recurso en específico.
     */
    public function show(Request $req, string $id)
    {
        //
    }

    /**
     * Mostrar el formulario para un recurso en especifico.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Actualizar un recurso en específico.
     */
    public function update(UpdateRecursoRequest $req, string $id)
    {
        //
    }

    /**
     * Eliminar un recurso en específico.
     */
    public function destroy(DestroyRecursoRequest $req, string $id)
    {
        //
    }
}
