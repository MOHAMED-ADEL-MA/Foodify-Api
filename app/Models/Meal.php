<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'image',
        'price',
        'calories',
        'protein',
        'carbs',
        'fat',
        'fiber',
        'rating',
    ];

    protected $casts = [
        'price'   => 'float',
        'protein' => 'float',
        'carbs'   => 'float',
        'fat'     => 'float',
        'fiber'   => 'float',
        'rating'  => 'float',
    ];


    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image
            ? Storage::url($this->image)
            : null;
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'meal_ingredients');
    }
}
