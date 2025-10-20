<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Acara extends Model
{
   use HasFactory, HasSlug;
    protected $table = 'acara';
    public function getSlugOptions() : SlugOptions{
        return SlugOptions::create()
        ->generateSlugsFrom('nama_acara')
        ->saveSlugsTo('slug'); 
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function jenisTiket()
    {
        return $this->hasMany(JenisTiket::class,'id_acara');
    }
}
