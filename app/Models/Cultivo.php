<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Cultivo extends Model
{
    use HasUlids, HasFactory;

    protected $primaryKey = "codigo";

    public $fillable = ["nombre", "variedad"];
    public $url;

    public function getUrlAttribute()
    {
        $route = route("cultivo.index");
        dump("{$route}/{$$this->codigo}");
        return $route;
    }

    public $appends = ["url"];
}
