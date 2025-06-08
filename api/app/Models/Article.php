<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $table = "articles";

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag', 'article_id', 'tag_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'save_articles');
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'article_id', 'id');
    }
}
