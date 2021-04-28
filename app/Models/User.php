<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'bio',
        'instagram',
        'twitter',
        'facebook',
        'website',
        'youtube_link_id',
        'profile_picture',
        'banner',
        'is_admin',
        'provider_id',
        'provider',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $subdays = 7;

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function sessionLikes()
    {
        return $this->hasMany(SessionLike::class);
    }
    
    public function sessionViews()
    {
        return $this->hasMany(SessionView::class);
    }

    public function gravatar($size = 150)
    {
        // d=mp --default
        // d=monsterid --monster 
        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $this->email ) ) ) . "?d=mp&s=" . $size;
    }

    public function getProfilePicture() 
    {
        if (str_contains($this->profile_picture, 'http')) {
            return $this->profile_picture;
        } else {
            return "/storage/" . $this->profile_picture;
        }
    }

    public function getBanner() 
    {
        return "/storage/" . $this->banner;
    }
    
    public function getURLmessage()
    {
        $url = null;
        if ($this->facebook) {
            $url = "http://m.me/" . $this->facebook;
        } else if ($this->twitter) {
            $url = "https://twitter.com/direct_messages/create/" . $this->twitter;
        }
        return $url;
    }

    public function getYoutubeLink()
    {
        $url = str_replace("https://","", $this->website);
        $fixURL = str_replace("www.","", $url);
        return $fixURL;
    }

    public function getShortName()
    {
        $arrFullname = explode(' ', $this->name);
        if (count($arrFullname) > 2) {
            $shortName = current($arrFullname) . ' ' . end($arrFullname);
            return $shortName;
        } else {
            return $this->name;
        }
    }

    public function getInsightPosts()
    {
        return $this->hasMany(Post::class)->where('created_at', '>', Carbon::now()->subDays($this->subdays));
    }

    public function getInsightViews()
    {
        return $this->hasMany(SessionView::class)->where('created_at', '>', Carbon::now()->subDays($this->subdays));
    }
    
    public function getInsightComments()
    {
        $arrPostId = Post::where('user_id', $this->id)->pluck('id')->toArray();
        return Comment::whereIn('post_id', $arrPostId)->where('created_at', '>', Carbon::now()->subDays($this->subdays));
    }
    
    public function getInsightLikes()
    {
        return $this->hasMany(SessionLike::class)->where('created_at', '>', Carbon::now()->subDays($this->subdays));
    }

    public function allComments()
    {
        $arrPostId = Post::where('user_id', $this->id)->pluck('id')->toArray();
        return Comment::whereIn('post_id', $arrPostId)->orderBy('created_at', 'DESC');
    }
}
