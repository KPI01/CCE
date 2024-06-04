<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    //

    // Variable para almacenar datos recuperados de la BD
    public $data;
    // Variable para guardar las relaciones del modelo
    public $relations;
    // Variable para el rol de administrador
    public $adm_role;
    // Variable para el usuario
    public $user;

    // Constructor
    public function __construct()
    {
        $this->adm_role = Role::where('name', 'Admin')->first()->id;
        $this->user = Auth::user();
        $this->relations = [];
    }
}
