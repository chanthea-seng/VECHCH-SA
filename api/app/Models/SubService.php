<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubService extends Model
{
    public $timestamps = false;
    protected $table = 'sub_services';

    protected $fillable = [
        'service_id',
        'description',
        'local_description',
        'price',
        'is_active'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function services()
    {
        return $this->belongsTo(Service::class, 'service_id');

    }

}
