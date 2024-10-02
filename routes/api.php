<?php
use App\Http\Controllers\Auxiliares\MaquinaAuxiliaresController;
use App\Http\Controllers\CultivoController;
use Illuminate\Support\Facades\Route;

Route::prefix("/api")
    ->middleware(["auth", "verified"])
    ->group(
        callback: function (): void {
            Route::get("/token", function () {
                return csrf_token();
            });

            Route::prefix("/recurso")->group(
                callback: function (): void {
                    Route::apiResource("cultivo", CultivoController::class);
                }
            );

            Route::prefix("/aux")->group(
                callback: function (): void {
                    Route::controller(
                        MaquinaAuxiliaresController::class
                    )->group(function () {
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
                    });
                }
            );
        }
    );
