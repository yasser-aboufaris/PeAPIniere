<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plante extends Model
{
    protected static function booted()
{
    static::creating(function ($plante) {
        $slug = Str::slug($plante->name, '-'); 
        $plante->slug = self::generateUniqueSlug($slug);
    });

    static::updating(function ($plante) {
        $slug = Str::slug($plante->name, '-');
        $plante->slug = self::generateUniqueSlug($slug);
    });
}

public static function generateUniqueSlug($slug)
{
    
    $count = self::where('slug', 'like', $slug.'%')->count();

    
    return $count ? "{$slug}-" . ($count + 1) : $slug;
}

}












