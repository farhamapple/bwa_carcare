<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StorePhoto extends Model
{
    //
    use SoftDeletes;

    protected $table = 'store_photos';

    protected $fillable = [
        'photo',
        'car_store_id',
    ];
}
