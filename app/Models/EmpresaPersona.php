<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Str;

class EmpresaPersona extends Pivot
{
    //
    use HasUuids;

    protected $table = "empresa_persona";
}
