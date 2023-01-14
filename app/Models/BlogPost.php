<?php

namespace App\Models;

use App\Scopes\DeletedAdminScopes;
use App\Scopes\LatestScopes;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    use HasFactory;
    use SoftDeletes, Taggable;

    // protected $table = 'blogposts';

    protected $fillable = ['title', 'content', 'user_id'];

    public function comments()
    {
        // return $this->hasMany('App\Models\Comment')->latest();
        return $this->morphMany('App\Models\Comment', 'commentable')->latest();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // public function tags()
    // {
    //     // return $this->belongsToMany('App\Models\Tag')->withTimestamps();
    //     return $this->morphToMany('App\Models\Tag', 'taggable')->withTimestamps();
    // }

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeMostCommented(Builder $query)
    {
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public function scopeWithLatestRelations(Builder $query)
    {
        return $query->latest()->withCount('comments')->with(['user', 'tags']);
    }

    public static function boot()
    {
        static::addGlobalScope(new DeletedAdminScopes);

        parent::boot();

        // static::addGlobalScope(new LatestScopes);

        // using observer
        // static::updating(function (BlogPost $post) {
        //     Cache::forget("blog-post-{$post->id}");
        // });

        // static::deleting(function (BlogPost $post) {
        //     $post->comments()->delete();
        //     Cache::forget("blog-post-{$post->id}");
        // });

        // static::restoring(function (BlogPost $post) {
        //     $post->comments()->restore();
        // });
    }
}