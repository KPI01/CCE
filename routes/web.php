<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\UserController;
// use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect(route('bienvenida'));
});

// Rutas de la app
Route::prefix('/cce')
    ->group(function () {
        Route::get('/', function () {
            // return Inertia::render('Bienvenida');
            return redirect(route('form.login'));
        })
        ->name('bienvenida');

        Route::prefix('/auth')
            ->group(function () {
                Route::controller(UserController::class)
                    ->group(function () {
                        Route::get('/login', 'login_form')
                            ->name('form.login');
                        Route::post('/login', 'login')
                            ->name('login.usuario');
                        Route::get('/registro', 'register_form')
                            ->name('form.registro');
                        Route::post('/registro', 'store')
                            ->name('store.usuario');
                        Route::get('/reset', 'reset_form')
                            ->name('form.reset-pass');

                        Route::prefix('/correo')
                            ->group(function () {
                                Route::get('/validar', 'confirm_email_form')
                                    ->name('verification.notice');
                                Route::get('/validar/{id}/{hash}', 'confirm_email')
                                    ->middleware('signed')
                                    ->name('verification.verify');
                                Route::post('/correo/notificación', 'send_email')
                                    ->middleware('throttle:6,1')
                                    ->name('verification.send');
                            });

                        Route::post('/reset', 'reset_form')
                            ->name('guardar_clave');
                    });
            })
            ->middleware('auth');

            Route::prefix('/app')
                ->group(function () {
                    Route::controller(AppController::class)
                        ->group(function () {
                            Route::get('/dashboard', 'dashboard')
                                ->name('dashboard.usuario');
                        });
                });
    });
