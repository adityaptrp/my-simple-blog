<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionView extends Model
{
    use HasFactory;

    protected $table = 'session_views';

    protected $fillable = ['user_id'];
}
