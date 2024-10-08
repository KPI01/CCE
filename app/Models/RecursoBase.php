<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class RecursoBase extends Model
{
    use HasFactory, HasUlids;

    protected $controller;
    public $incrementing = false;
    protected $guarded = [];

    public function getUrlAttribute()
    {
        $name = strtolower(class_basename($this));
        $base = route("{$name}.index");
        $path = Request::create($base)->path();
        $url = url("/{$path}/{$this->id}");
        return $url;
    }
    protected $appends = ["url"];

    protected function casts()
    {
        return [
            "created_at" => "datetime:Y-m-d H:i",
            "updated_at" => "datetime:Y-m-d H:i",
            "url" => "string",
        ];
    }
}
