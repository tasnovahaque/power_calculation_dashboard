<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    //add table name
    protected $table = 'datas';

    protected $fillable = [
        'device_id',
        'record_time',
        'energy',
        'voltage',
        'current',
    ];
}
