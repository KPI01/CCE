<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AppController extends Controller
{
    //

    /**
     * Función constructor
     */
    public function __construct()
    {
        $this->adm_role = Role::where('name', 'Admin')->first()->id;
        $this->user = Auth::user();
    }

    /**
     * Muestra de dashboard para el usuario
     */
    public function index()
    {

        if ($this->user->role_id == $this->adm_role) {
            return Inertia::render('Dashboard');
        }
        return Inertia::render('User/Dashboard');
    }

    /**
     * Redirige al dashboard
     *
     * @param Request $req
     */
    public function redirect_home(Request $req)
    {
        $source = $req->path();

        if (Auth::check()) {
            return redirect()->route('home')->with('from', $source);
        }

        return redirect()->route('login')->with('', $source);

    }
}
