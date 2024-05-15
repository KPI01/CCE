<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

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
        $user_role = Role::firstOrCreate([
            'name' => 'Usuario',
        ]);

        $vals['role_id'] = $user_role->id;

        $user = User::create($vals);
        event(new Registered($user));

        Auth::login($user);

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

        return redirect(route('dashboard.usuario'));
    }

    /**
     * Enviar correo de validación automáticamente
     *
     * @param Request $req
     */
    public function send_email(Request $req)
    {
        $req->user()->sendEmailVerificationNotification();

        return back()->with('msj', 'Correo de verificación enviado');
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

        if (Auth::check()) {
            return redirect()->intended(route('dashboard.usuario'));
        }

        if (Auth::attempt($credentials)) {
            $req->session()->regenerate();
            return redirect()->intended(route('dashboard.usuario'));
        }

        return back()->withErrors([
            'email' => 'Las credenciales son inválidas.',
        ])->onlyInput('email');

    }

    /**
     * Cerrar sesión de usuario
     *
     * @param Request $req
     */
    public function logout(Request $req)
    {

        if (Auth::check()) {
            $req->session()->invalidate();

            return redirect(route('login'));
        } else {
            return redirect()->intended(route('login'))->withErrors([
                'email' => 'No hay una sesión activa.',
            ]);
        }
    }

    /**
     * Restablecer clave de usuario
     *
     * @param Request $req
     */
    public function reset_pass(Request $req)
    {

    }
}
