<?php

namespace App\Models;

use App\Scopes\LatestScopes;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
    use HasFactory, Taggable;

    protected $fillable = ['user_id', 'content'];

    protected $hidden = ['deleted_at', 'commentable_type', 'commentable_id', 'user_id'];

    public function commentable()
    {
        return $this->morphTo();
    }

    // adding using traits
    // public function tags()
    // {
    //     return $this->morphToMany('App\Models\Tag', 'taggable')->withTimestamps();
    // }

    // public function blogPosts()
    // {
    //     return $this->belongsTo('App\Models\BlogPost', 'blog_post_id');
    // }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public static function boot()
    {
        parent::boot();

        // static::addGlobalScope(new LatestScopes);

        // static::creating(function (Comment $comment) {
        //     // Cache::forget("blog-post-{$comment->blog_post_id}");
        //     if ($comment->commentable_type === BlogPost::class) {
        //         Cache::forget("blog-post-{$comment->commentable_id}");
        //         Cache::forget("mostCommented");
        //     }
        // });
    }
}