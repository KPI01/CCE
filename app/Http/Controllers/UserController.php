<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class UserController extends Controller
{
    //

    /**
     * Mostrar formulario de registro de usuario
     */
    public function register_form()
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Mostrar formulario de inicio de sesión 
     */
    public function login_form()
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Mostrar formulario de reseteo de clave
     */
    public function reset_form()
    {
        return Inertia::render('Auth/ResetPassword');
    }

    /**
     * Guardar un nuevo usuario
     * 
     * @param Request $req
     */
    public function store(Request $req)
    {
        $vals = $req->input();
        $user_role = Role::where('name', 'Usuario')->first();

        unset($vals['confirmPassword']);
        $vals['role_id'] = $user_role->id;

        User::create($vals);

        return Inertia::render('Auth/Register', [
            'form_sent' => true,
            'register_done' => true,
            'vals' => $vals
        ]);
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

    /**
     * Enviar código de validación al correo
     * 
     * @param Request $req
     */
    public function send_code(Request $req)
    {
        $email = $req->input('email');
        $user = User::where('email', $email)->first();
        

    }

    /**
     * Reestablecer clave de usuario
     * 
     * @param Request $req
     */
    public function reset_pass(Request $req) 
    {

    }
}
