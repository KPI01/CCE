<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AppController extends Controller
{
    //

    /**
     * Muestra de dashboard para el usuario común
     */
    public function dashboard()
    {
        return Inertia::render('User/Dashboard');
    }
}
