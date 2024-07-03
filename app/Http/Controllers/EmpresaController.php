<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyRecursoRequest;
use App\Models\Empresa;
use App\Http\Requests\StoreRecursoRequest;
use App\Http\Requests\UpdateRecursoRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmpresaController extends RecursoController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        //
        $this->data = Empresa::all();

        return Inertia::render("Recursos/Empresas/Table", [
            'data' => $this->indexAll('empresas', $this->data),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StoreRecursoRequest $request)
    {
        //
    }

    public function show(Request $req, string $id)
    {
        //
        $this->data = Empresa::findOrFail($id);
        $this->relations['personas'] = $this->data->personas()->get();
        $this->data->personas = $this->relations['personas'];

        return Inertia::render("Recursos/Empresas/Show", [
            'data' => $this->data,
            'isAdmin' => $this->user->role_id == $this->adm_role
        ]);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(UpdateRecursoRequest $req, string $id)
    {
        //
    }

    public function destroy(DestroyRecursoRequest $req, string $id)
    {
        //
    }
}
