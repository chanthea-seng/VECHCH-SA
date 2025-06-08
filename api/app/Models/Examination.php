<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    public $timestamps = false;
    protected $table = 'examinations';
    protected $fillable = ['medical_record_id', 'name', 'result', 'status'];
}
