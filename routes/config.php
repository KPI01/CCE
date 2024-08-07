<?php
use App\Http\Controllers\Auxiliares\TiposMaquinaController;
use Illuminate\Support\Facades\Route;

Route::prefix("app/config")
    ->middleware(["auth", "verified"])
    ->group(function () {
        Route::prefix("auxiliares")->group(function () {
            Route::apiResource("tipos_maquina", TiposMaquinaController::class);
        });
    });
