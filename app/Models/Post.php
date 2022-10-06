<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'image',
        'category_id',
    ];

    public function scopeSearch(Builder $query, $search)
    {
        if (!empty($search['title'])) {
            $query->where('title', 'like', '%' . $search['title'] . '%');
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }


    // 写真
    public function getImagePathAttribute()
    {
        return 'images/posts/' . $this->image;
    }

    // 開始時刻の日付
    public function getStartDateAttribute()
    {
        return (new Carbon($this->start))->toDateString();
    }

}
