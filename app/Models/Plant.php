<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\Slugable;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Str;

class Plant extends Model
{
    use Sluggable;
    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
        'categorie_id',
        'slug',
    ];

    /**
     * Get the options for generating the slug.
     *
     * @return \Spatie\Sluggable\SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugFrom('name')  
            ->saveSlugTo('slug');
    }
}
