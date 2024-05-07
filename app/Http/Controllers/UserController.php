<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    //
    /**
     * Mostrar formulario de registro de usuario
     */
    public function register_form()
    {
        return Inertia::render('Auth/_Register');
    }

    /**
     * Mostrar formulario de inicio de sesión 
     */
    public function login_form()
    {
        return Inertia::render('Auth/_Login');
    }

    /**
     * Guardar un nuevo usuario
     * 
     * @param Request $req
     */
    public function store(Request $req)
    {

    }

    /**
     * Actualizar datos de usuario
     * 
     * @param Request $req
     * @param string $id
     */
    public function update(Request $req, string $id)
    {

    }

    /**
     * Validar sesión de usuario
     * 
     * @param Request $req
     */
    public function login(Request $req)
    {

    }

    /**
     * Cerrar sesión de usuario
     * 
     * @param Request $req
     */
    public function logout(Request $req)
    {

    }
}
