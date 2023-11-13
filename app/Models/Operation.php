<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;

    const CREDIT = 'credit';
    const DEBIT = 'debit';

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'wallet_id',
        'operation_type',
        'ammount',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }

    public function transactionOrigin()
    {
        return $this->hasOne(Transaction::class, 'origin');
    }

    public function transactionDestination()
    {
        return $this->hasOne(Transaction::class, 'destination');
    }
}
