<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecursoBase extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = "string";
    public $incrementing = false;
    protected $guarded = [];

    public function getUrlsAttribute()
    {
        $name = strtolower(class_basename($this));
        return [
            "index" => route("{$name}.index"),
            "show" => route("{$name}.show", $this->id),
            "edit" => route("{$name}.edit", $this->id),
            "update" => route("{$name}.update", $this->id),
            "destroy" => route("{$name}.destroy", $this->id),
        ];
    }
    protected $appends = ["urls"];
    protected $casts = [
        "urls" => "array",
    ];

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->format("Y-m-d H:i:s");
    }
    public function getUpdatedAtAttribute($value): string
    {
        return Carbon::parse($value)->format("Y-m-d H:i:s");
    }
}
