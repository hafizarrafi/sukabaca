<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'author_id',
        'news_category_id',
        'title',
        'slug',
        'thumbnail',
        'content'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function NewsCategory()
    {
        return $this->belongsTo(NewsCategory::class);
    }

    public function banner()
    {
        return $this->hasOne(Banner::class);
    }
}
