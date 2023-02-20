<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Customer;
use App\Models\TransactionDetail;
use App\Models\TransactionMember;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'transactions';

    protected $fillable = [
        'customer_id',
        'total_day',
        'start_date',
        'end_date',
        'total',
        'status',
        'approved_at'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function details() {
        return $this->hasMany(TransactionDetail::class);
    }

    public function members() {
        return $this->hasMany(TransactionMember::class);
    }
}
