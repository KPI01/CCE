<?php
use App\Http\Controllers\Auxiliares\MaquinaAuxiliaresController;
use App\Http\Controllers\CultivoController;
use App\Http\Resources\CultivoResource;
use App\Models\Cultivo;
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
                    Route::controller(CultivoController::class)->group(
                        callback: function (): void {
                            Route::get("/cultivo", "apiIndex");
                            Route::post("/cultivo", "apiStore");
                            Route::patch("/cultivo/{cultivo}", "apiUpdate");
                            Route::put("/cultivo/{cultivo}", "apiUpdate");
                            Route::delete("/cultivo/{cultivo}", "apiDestroy");
                        }
                    );
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
