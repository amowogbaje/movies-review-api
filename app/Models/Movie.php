<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'thumbnail', 'release_date', 'genre'];

    public function reviews() {
        return $this->hasMany(Review::class);
    }
    
    protected function averageRating(): Attribute {
        return Attribute::make(
            get: fn() => $this->reviews()->avg('rating') ?? 0
        );
    }
    
    protected function totalReviews(): Attribute {
        return Attribute::make(
            get: fn() => $this->reviews()->count()
        );
    }
}
