<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //

    /**
     * Mostrar formulario de registro de usuario
     */
    public function register_form()
    {
        return Inertia::render('NoAuth/Register');
    }

    /**
     * Mostrar formulario de inicio de sesión
     */
    public function login_form()
    {
        return Inertia::render('NoAuth/Login');
    }

    /**
     * Mostrar formulario de reseteo de clave
     */
    public function reset_form()
    {
        return Inertia::render('NoAuth/ResetPassword');
    }

    /**
     * Mostrar diálogo de confirmación de correo
     */
    public function confirm_email_form()
    {
        return Inertia::render('NoAuth/ConfirmEmail');
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

        $vals['role_id'] = $user_role->id;

        User::create($vals);

        return redirect(route('verification.notice'));
    }

    /**
     * Validación de correo del usuario
     *
     * @param EmailVerificationRequest $req
     */
    public function confirm_email(EmailVerificationRequest $req)
    {
        $req->fulfill();

        return redirect(route('form.login'));
    }

    /**
     * Enviar correo de validación automáticamente
     *
     * @param Request $req
     */
    public function send_email(Request $req)
    {
        $req->user()->sendEmailVerificationNotification();

        return back()->with('mensaje', 'Correo de verificación enviado');
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
        $credentials = $req->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $req->input('email'))->first();

        if (!Auth::check()) {

            if (Auth::attempt($credentials)) {
                $req->session()->regenerate();
                return redirect(route('dashboard.usuario'));
            } else {
                return back()->withErrors([
                    'email' => 'Correo y clave inválida'
                ])->onlyInput('email');
            }
        }

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
