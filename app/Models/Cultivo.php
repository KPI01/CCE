<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cultivo extends RecursoBase
{
    use HasUlids;

    protected $table = "cultivos";
    protected $primaryKey = "codigo";
    protected $primaryType = "string";
}
