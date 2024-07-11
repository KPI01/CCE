<?php

namespace App\Http\Controllers;

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
        parent::__construct();
    }

    /**
     * Muestra de dashboard para el usuario
     */
    public function index()
    {
        return Inertia::render("Dashboard");
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
            return redirect()->route("home")->with("from", $source);
        }

        return redirect()->route("login")->with("", $source);
    }
}
