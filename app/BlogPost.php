<?php

namespace App;

use App\Scopes\DeletedAdminScope;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    // protected $table = "blogposts";

    use SoftDeletes;

    protected $fillable = ['title', 'content', 'user_id'];

    public function comments()
    {
        return $this->hasMany('App\Comment')->latest();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag')->withTimestamps()->as('tagged');
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeMostCommented(Builder $query)
    {
        // comments count
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public static function boot()
    {
        static::addGlobalScope(new DeletedAdminScope);

        parent::boot();
        // when model is being deleted EVENT
        static::deleting(function(BlogPost $blogPost) {
            // dd('I am going to delete');
            $blogPost->comments()->delete();
        });

        static::updating(function(BlogPost $blogPost) {
           Cache::forget("blog-post-{$blogPost->id}");
        });

        // when model is being restoring EVENT
        static::restoring(function(BlogPost $blogPost) {
            // dd('I am going to restore');
            $blogPost->comments()->restore();
        });
    }
}
