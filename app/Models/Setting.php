<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['auth_wallpaper', 'auth_caption', 'auth_owner_name', 'auth_unsplash_username'];

    public function getAuthWallpaper()
    {
        return "/storage/" . $this->auth_wallpaper;
    }

    public function getURLOwnerPictAuth() {
        return 'https://unsplash.com/@' . $this->auth_unsplash_username;
    }
}
