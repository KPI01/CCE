<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    //

    // Variable para almacenar datos recuperados de la BD o request
    public $data;
    // Variable para el rol de administrador
    public $adm_role;
    // Variable para el usuario
    public $user;
    // Variable para instancia de modelo
    public $instance;
    // Variable para devolver mensajes al usuario
    public $message;

    // Constructor
    public function __construct()
    {
        $this->adm_role = Role::where("name", "Admin")->first()->id;
        $this->user = Auth::user();
    }
}
