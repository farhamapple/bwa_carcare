<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CarService extends Model
{
    //
    use SoftDeletes;

    protected $table = 'car_services';

    protected $fillable = [
        'name',
        'photo',
        'price',
        'duration_in_hour',
        'icon',
        'about',
        'slug',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function carStores(): HasMany
    {
        return $this->hasMany(CarStore::class);
    }
}
