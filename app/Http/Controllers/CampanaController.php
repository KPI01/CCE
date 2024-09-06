<?php

namespace App\Http\Controllers;

use App\Models\Campana;
use Illuminate\Http\Request;

class CampanaController extends Controller
{
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
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Campana $campana)
    {
        //
    }

    public function edit(Campana $campana)
    {
        //
    }

    public function update(Request $request, Campana $campana)
    {
        //
    }

    public function destroy(Campana $campana)
    {
        //
    }
}
