<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Str;

class Plante extends Model
{
    use HasSlug;
    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
        'categorie_id',
        'slug',
    ];
    
    
    public function getSlugOptions(): SlugOptions
{
    return SlugOptions::create()
        ->generateSlugsFrom('name')
        ->saveSlugsTo('slug');
}

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
