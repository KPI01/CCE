<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class RecursoBase extends Model
{
    use HasFactory, HasUuids;

    protected $controller;
    protected $keyType = "string";
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
