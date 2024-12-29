<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CarStore extends Model
{
    //
    use SoftDeletes;

    protected $table = "car_stores";

    protected $fillable = [
        'name',
        'thumbnail',
        'phone_number',
        'address',
        'cs_name',
        'is_open',
        'is_full',
        'slug',
        'city_id',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function storePhotos(): HasMany
    {
        return $this->hasMany(StorePhoto::class);
    }

    public function storeServices(): HasMany
    {
        return $this->hasMany(StoreService::class);
    }
}
