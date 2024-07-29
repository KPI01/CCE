<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PersonaController;

Route::prefix("app")
    ->middleware(["auth", "verified"])
    ->group(function () {
        Route::controller(AppController::class)->group(function () {
            Route::get("/", "redirect_home");
            Route::get("home", "index")->name("home");
        });

        Route::prefix("admin")
            ->middleware("auth")
            ->group(function () {
                Route::controller(AppController::class)->group(function () {
                    Route::get("/", "redirect_home");
                });
            });

        Route::prefix("recurso")->group(function () {
            Route::resource("personas", PersonaController::class);
            Route::resource("empresas", EmpresaController::class);
        });
    });
