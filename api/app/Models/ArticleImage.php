<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleImage extends Model
{
    public $timestamps = false;
    protected $table = 'article_images';
    protected $fillable = [
        'article_id',
        'image_path'
    ];
}
