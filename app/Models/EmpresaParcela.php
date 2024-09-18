<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EmpresaParcela extends Pivot
{
    //
    public $table = "empresa_parcela";
    public $incrementing = true;
}
