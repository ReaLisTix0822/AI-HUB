<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiTool extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'tagline',
        'tagline_th',
        'description',
        'description_th',
        'logo_url',
        'website_url',
        'pricing_type',
        'pricing_details',
        'pricing_details_th',
        'features',
        'features_th',
        'tasks',
        'tasks_th',
        'strengths',
        'best_for',
        'best_for_th',
        'popularity_score',
        'is_featured',
    ];

    protected $casts = [
        'features' => 'array',
        'features_th' => 'array',
        'tasks' => 'array',
        'tasks_th' => 'array',
        'strengths' => 'array',
        'is_featured' => 'boolean',
        'popularity_score' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
