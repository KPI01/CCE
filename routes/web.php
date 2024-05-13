<?php

// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
// use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//      Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//      Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//  });

// Rutas de la app
Route::prefix('/cce')
    ->group(function () {
        Route::get('/', function () {
            return Inertia::render('Bienvenida');
        });

        Route::prefix('/auth')
            ->group(function () {
                Route::controller(UserController::class)
                    ->group(function () {
                        Route::get('/login', 'login_form')
                            ->name('login');
                        Route::post('/login', 'login')
                            ->name('validar_login');
                        Route::get('/registro', 'register_form')
                            ->name('registro');
                        Route::post('/registro', 'store')
                            ->name('nuevo_usuario');
                        Route::get('/reset', 'reset_form')
                            ->name('reset_clave');
                        Route::get('/reset/', 'reset_form')
                            ->name('reset_clave');
                        Route::get('/validar-email', function () {
                            return route('registro');
                        })
                            ->name('verification.notice');
                        Route::post('/reset', 'reset_form')
                            ->name('guardar_clave');
                    });
            })
            ->middleware('auth');
    });

// require __DIR__ . '/auth.php';
