<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceImage extends Model
{
    public $timestamps = false;

    protected $fillable = ['service_id', 'image_path'];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
