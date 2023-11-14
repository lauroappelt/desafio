<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Operation;
class Transaction extends Model
{
    use HasFactory;

    const TRANSACTION_DEBIT = 'debit';
    const TRANSACTION_CREDIT = 'credit';

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'origin',
        'destination',
    ];

    public function originOperation()
    {
        return $this->belongsTo(Operation::class, 'origin');
    }

    public function destinationOperation()
    {
        return $this->belongsTo(Operation::class, 'destination');
    }
}
