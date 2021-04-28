<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    protected static function boot() {
        parent::boot();
    
        static::deleting(function($tag) {
            $tag->posts()->detach();
        });
    }

    public function posts() {
        return $this->belongsToMany(Post::class);
    }
}
