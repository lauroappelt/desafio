<?php
namespace App\Notifications;

use App\Models\Transaction;

interface TransactionNotificationInteface
{
    public function notify(Transaction $transaction): void;
}