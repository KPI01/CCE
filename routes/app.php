<?php

use App\Http\Controllers\CampanaController;
use App\Http\Controllers\CultivoController;
use App\Http\Controllers\MaquinaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PersonaController;

Route::prefix("/app")
    ->middleware(["auth", "verified"])
    ->group(function () {
        /**
         * Rutas generales para la aplicación
         */
        Route::controller(AppController::class)->group(function () {
            Route::get("/", "redirect_home");
            Route::get("/home", "index")->name("home");
        });

        /**
         * Rutas para recursos
         */
        Route::prefix("/recurso")->group(function () {
            Route::resource("persona", PersonaController::class);
            Route::resource("empresa", EmpresaController::class);
            Route::resource("maquina", MaquinaController::class);
            Route::resource("campana", CampanaController::class);
        });

        /**
         * Rutas para auxiliares
         */
        Route::prefix("/aux")->group(function () {
            Route::apiResource("cultivo", CultivoController::class);
            Route::controller(MaquinaController::class)->group(function () {
                $name = "aux.maquina";
                Route::get("maquina/{tabla?}", "indexAux")
                    ->name("{$name}.index")
                    ->defaults("tabla", "maquina_tipo");
            });
        });
    });
