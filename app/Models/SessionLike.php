<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionLike extends Model
{
    use HasFactory;

    protected $table = 'session_likes';

    protected $fillable = ['user_id'];
}
