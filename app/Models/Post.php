<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'title', 'slug', 'subtitle', 'header', 'body', 'footer', 'quote', 'quote_author', 'thumbnail', 'sub_thumbnail1', 'sub_thumbnail2', 'youtube_link'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->orderBy('counts_like', 'DESC')->orderBy('created_at', 'ASC');
    }

    public function allComments() {
        return $this->hasMany(Comment::class)->orderBy('counts_like', 'DESC');
    }
    
    public function allCommentsApproverd() {
        return $this->hasMany(Comment::class)->where('is_approved', 1)->orderBy('counts_like', 'DESC');
    }

    public function getThumbnail() 
    {
        if ($this->thumbnail == null) {
            return url('img/default_post.jpg');
        } else {
            $isUrl = stristr($this->thumbnail, 'http://') ?: stristr($this->thumbnail, 'https://') ?: stristr($this->thumbnail, 'www.');
            if($isUrl) {
                return $this->thumbnail;
            }
            return asset('/storage/' . $this->thumbnail);
        }
    }

    public function getSubThumbnail1() 
    {
        if ($this->sub_thumbnail1 == null) {
            return url('img/default_post.jpg');
        } else {
            $isUrl = stristr($this->sub_thumbnail1, 'http://') ?: stristr($this->sub_thumbnail1, 'https://') ?: stristr($this->sub_thumbnail1, 'www.');
            if($isUrl) {
                return $this->sub_thumbnail1;
            }
            return asset('/storage/' . $this->sub_thumbnail1);
        }
    }

    public function getSubThumbnail2() 
    {
        if ($this->sub_thumbnail2 == null) {
            return url('img/default_post.jpg');
        } else {
            $isUrl = stristr($this->sub_thumbnail2, 'http://') ?: stristr($this->sub_thumbnail2, 'https://') ?: stristr($this->sub_thumbnail2, 'www.');
            if($isUrl) {
                return $this->sub_thumbnail2;
            }
            return asset('/storage/' . $this->sub_thumbnail2);
        }
    }

    public function youtubeLink() {
        $youtubeLink = explode('/', $this->youtube_link);
        return $youtubeLink[3];
    }

    public function checkPopularPost()
    {
        $sizeAllPost = sizeof(Post::get());
        if ($sizeAllPost > 5) {
            $mount = intval(round((20/100) * $sizeAllPost));
        } else {
            $mount = 2;
        }
        $popularPost = Post::orderBy('views_count', 'DESC')->take($mount)->pluck('id')->toArray();
        if (in_array($this->id, $popularPost)) {
            return '&#9733;';
        } else {
            return false;
        }
    }

    public function estimatedReadingTime()
    {
        $header = str_word_count($this->header);
        $body = str_word_count(strip_tags($this->body));
        $footer = str_word_count(strip_tags($this->footer));
        $allWord = $header + $body + $footer;
        $m = intval(floor($allWord / 250));
        $s = intval(floor($allWord % 250 / (250 / 60)));
        $est = ($m == 0 ? '1 min read' : "$m min read");
        return $est;
    }

    public function allTagsShareTwitter() {
        $arrTags = [];
        foreach ($this->tags as $tag) {
            $tagName = str_replace(' ', '', $tag->name);
            array_push($arrTags, $tagName);
        }
        return implode(',', $arrTags);
    }

    public function getURL()
    {
        $arrRecentUrl = explode('-', $this->slug);
        $codePost = end($arrRecentUrl);
        $fullURL = explode('/', request()->url());
        $url = $fullURL[0] . '//' . $fullURL[2] . '/' . $codePost;
        return $url;
    }
}
