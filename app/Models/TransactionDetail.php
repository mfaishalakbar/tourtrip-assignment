<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Hotel;
use App\Models\Trip;
use App\Models\Transaction;

class TransactionDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transaction_details';

    protected $fillable = [
        'transaction_id',
        'trip_id',
        'hotel_id',
        'start_date',
        'end_date',
        'price',
        'total_price'
    ];

    public function transaction() {
        return $this->hasOne(Transaction::class);
    }

    public function hotel() {
        return $this->belongsTo(Hotel::class);
    }

    public function trip() {
        return $this->belongsTo(Trip::class);
    }
}
