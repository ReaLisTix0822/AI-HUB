<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'name_th',
        'slug',
        'icon',
        'description',
        'order',
    ];

    public function aiTools()
    {
        return $this->hasMany(AiTool::class);
    }
}
