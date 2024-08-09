<?php
use App\Http\Controllers\Auxiliares\MaquinaAuxiliaresController;
use Illuminate\Support\Facades\Route;

Route::prefix("app/config")
    ->middleware(["auth", "verified"])
    ->group(function () {
        Route::prefix("auxiliares")->group(function () {
            Route::controller(MaquinaAuxiliaresController::class)->group(
                function () {
                    $name = "aux_maquina";
                    Route::get("maquina/{tabla?}", "index")
                        ->name("{$name}.index")
                        ->defaults("tabla", "tipos_maquina");
                    Route::post("maquina/{tabla}", "store")->name(
                        "{$name}.store"
                    );
                    Route::put("maquina/{tabla}/{id}", "update")->name(
                        "{$name}.update"
                    );
                    Route::delete("maquina/{tabla}/{id}", "destroy")->name(
                        "{$name}.destroy"
                    );
                }
            );
        });
    });
