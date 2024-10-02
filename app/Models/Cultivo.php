<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cultivo extends Model
{
    use HasUlids, HasFactory;

    public $fillable = ["nombre", "variedad"];
    public $url;

    public function getUrlAttribute()
    {
        $route = route("cultivo.index");
        $url = "{$route}/{$this->id}";
        return $url;
    }

    public $appends = ["url"];
}
