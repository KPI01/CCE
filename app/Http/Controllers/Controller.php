<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    //
    protected Authenticatable | null $user;
    protected Model $inst;
    protected Collection | Model $data;
    protected string $msg;

    // Constructor
    public function __construct()
    {
        $this->user = Auth::user();
    }

    protected function indexAll(string $recurso, Collection $data)
    {
        return $data->map(function ($data) use ($recurso) {
            return [
                ...$data->toArray(),
                "urls" => [
                    "edit" => route("$recurso.edit", $data->id),
                    "destroy" => route("$recurso.destroy", $data->id),
                    "show" => route("$recurso.show", $data->id),
                ],
            ];
        });
    }
}
