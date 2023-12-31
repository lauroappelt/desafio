<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'balance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function operation()
    {
        return $this->hasMany(Operation::class, 'wallet_id');
    }
}
