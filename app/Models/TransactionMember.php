<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Transaction;

class TransactionMember extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'transaction_members';

    protected $fillable = [
        'transaction_id',
        'name',
        'place_of_birth',
        'date_of_birth',
        'address',
        'gender',
    ];

    public function transaction() {
        return $this->hasOne(Transaction::class);
    }

}
