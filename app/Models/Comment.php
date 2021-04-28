<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'parent_id', 'name', 'email', 'body', 'selected_text', 'counts_like', 'is_approved', 'user_link'];

    public function replies() {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function gravatar($size = 150)
    {
        $user = User::where('email', $this->email)->first();
        if ($user) {
            if (str_contains($user->profile_picture, 'http')) {
                return $user->profile_picture;
            } else {
                return "/storage/" . $user->profile_picture;
            }
        } else {
            return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $this->email ) ) ) . "?d=monsterid&s=" . $size;
        }
    }
}
