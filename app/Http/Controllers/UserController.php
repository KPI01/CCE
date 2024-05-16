<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;
use Illuminate\Support\Str;

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
    public function reset_pass_request_form()
    {
        return Inertia::render('NoAuth/ResetPasswordRequest');
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
     * Petición de restablecer clave de usuario
     *
     * @param Request $req
     */
    public function reset_pass_request(Request $req)
    {
        $req->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $req->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Formulario de restablecer clave de usuario
     *
     * @param string token
     */
    public function reset_pass_form(string $token)
    {
        return Inertia::render('NoAuth/ResetPasswordForm', ['token' => $token]);
    }

    /**
     * Restablecimiento de clave
     *
     * @param Request $req
     */
    public function reset_pass(Request $req)
    {
        $req->validate([
            'email'=> ['required','email'],
            'token'=> ['required'],
            'password'=> ['required', 'confirmed'],
        ]);

        $status = Password::reset(
            $req->only('email', 'password', 'password_confirmation', 'token'),
            function(User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])
                ->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
