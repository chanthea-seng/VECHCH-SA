<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'local_name',
        'description',
        'local_description',
        'service_type',
        'instruction'
    ];
    public function subServices()
    {
        return $this->hasMany(SubService::class, 'service_id', 'id');
    }
    public function serviceImages()
    {
        return $this->hasMany(ServiceImage::class, 'service_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
