<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;
    protected $table = 'categories';

    public function articles(){
        return $this->hasMany(Article::class,'category_id','id');
    }
}
