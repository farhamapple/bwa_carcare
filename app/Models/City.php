<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class City extends Model
{
    use SoftDeletes;

    protected $table = 'cities';

    protected $fillable = ['name', 'slug'];

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
