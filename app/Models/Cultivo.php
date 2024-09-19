<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cultivo extends Model
{
    use HasUlids, HasFactory;

    protected $primaryKey = "codigo";

    public $fillable = ["nombre", "variedad"];
}
