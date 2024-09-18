<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Cultivo extends Model
{
    use HasUlids;

    protected $primaryKey = "codigo";

    public $fillable = ["nombre", "variedad"];
}
