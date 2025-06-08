<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = ['medical_record_id', 'name', 'dosage', 'frequency', 'duration'];
    public $timestamps = false;
}
