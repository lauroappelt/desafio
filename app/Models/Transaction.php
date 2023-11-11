<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'ammount',
        'payer',
        'payee'
    ];

    public function payer()
    {
        return $this->belongsTo(Wallet::class, 'payer');
    }

    public function payee()
    {
        return $this->belongsTo(Wallet::class, 'payee');
    }
}
