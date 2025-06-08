<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaveArticle extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'save_articles';

    protected $fillable = ['user_id', 'article_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}
