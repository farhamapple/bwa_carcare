<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreService extends Model
{
    //
    use SoftDeletes;

    protected $table = 'store_services';
    protected $fillable = ['car_service_id', 'car_store_id'];

    public function carService(): BelongsTo
    {
        return $this->belongsTo(CarService::class);
    }

    public function carStore(): BelongsTo
    {
        return $this->belongsTo(CarStore::class);
    }
}
