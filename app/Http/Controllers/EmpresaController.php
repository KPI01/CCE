<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyRecursoRequest;
use App\Models\Empresa;
use App\Http\Requests\StoreEmpresaRequest;
use App\Http\Requests\StoreRecursoRequest;
use App\Http\Requests\UpdateRecursoRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmpresaController extends RecursoController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $this->data = Empresa::all();

        return Inertia::render("Recursos/Empresas/Table", [
            'data' => $this->data,
            'isAdmin' => $this->user->role_id == $this->adm_role
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
    public function store(StoreRecursoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecursoRequest $req, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyRecursoRequest $req, string $id)
    {
        //
    }
}
