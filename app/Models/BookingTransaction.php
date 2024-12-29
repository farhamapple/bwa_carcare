<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Node\Expr\FuncCall;

class BookingTransaction extends Model
{
    //

    use SoftDeletes;

    protected $table = 'booking_transactions';

    protected $fillable = [
        'name',
        'trx_id',
        'phone_number',
        'proof',
        'total_amount',
        'is_paid',
        'started_at',
        'time_at',
        'car_service_id',
        'car_store_id',
    ];

    public function carService(): BelongsTo
    {
        return $this->belongsTo(CarService::class);
    }

    public function carStore(): BelongsTo
    {
        return $this->belongsTo(CarStore::class);
    }
}
