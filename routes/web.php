<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [AppController::class, 'redirect_home'])->name('root');

// Rutas de la app
Route::prefix('/cce')
    ->group(function () {
        Route::controller(AppController::class)->group(function () {
            Route::get('/', 'redirect_home');
        });

        Route::prefix('auth')
            ->group(function () {
                Route::get('/', function () {
                    return redirect(route('login'));
                });

                Route::controller(UserController::class)
                    ->group(function () {
                        Route::middleware('guest')
                            ->group(function () {
                                Route::get('/login', 'login_form')
                                    ->name('login');
                                Route::post('/login', 'login')
                                    ->name('login.usuario');
                                Route::get('/registro', 'register_form')
                                    ->name('registro');
                                Route::post('/registro', 'store')
                                    ->name('store.usuario');
                            });

                        Route::prefix('correo')
                            ->middleware('auth')
                            ->group(function () {
                                Route::get('/', function () {
                                    if (Auth::check()) {
                                        return redirect(route('dashboard.usuario'));
                                    } else {
                                        return redirect(route('verification.notice'));
                                    }
                                });
                                Route::get('/validar', 'confirm_email_form')
                                    ->name('verification.notice');
                                Route::get('/validar/{id}/{hash}', 'confirm_email')
                                    ->middleware(['auth', 'signed'])
                                    ->name('verification.verify');
                                Route::post('/correo/notificación', 'send_email')
                                    ->middleware(['auth', 'throttle:6,1'])
                                    ->name('verification.send');
                            });

                        Route::prefix('clave')
                            ->middleware('guest')
                            ->group(function () {
                                Route::get('/olvido', 'reset_pass_request_form')
                                    ->name('password.request');
                                Route::post('/olvido', 'reset_pass_request')
                                    ->name('password.email');
                                Route::get('/reseteo/{token}', 'reset_pass_form')
                                    ->name('password.reset');
                                Route::post('/reseteo', 'reset_pass')
                                    ->name('password.update');
                            });

                        Route::post('/logout', 'logout')
                            ->name('logout');
                    });
            });


        Route::prefix('app')
            ->middleware(['auth', 'verified'])
            ->group(function () {
                Route::controller(AppController::class)
                    ->group(function () {
                        Route::get('/', 'redirect_home');
                        Route::get('home', 'index')
                            ->name('home');
                    });

                Route::prefix('admin')
                    ->middleware('auth')
                    ->group(function () {
                        Route::controller(AppController::class)
                            ->group(function () {
                                Route::get('/', 'redirect_home');
                            });
                    });

                Route::prefix('recurso')
                    ->group(function () {
                        Route::resource('personas', PersonaController::class)
                        ->missing(function () {
                            return redirect(route('personas.index'));
                        });
                        Route::resource('empresas', EmpresaController::class);
                    });

            });
    });
