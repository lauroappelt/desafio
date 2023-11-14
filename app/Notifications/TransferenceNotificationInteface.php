<?php
namespace App\Notifications;

use App\Models\Transaction;

interface TransferenceNotificationInteface
{
    public function notify(Transaction $transaction): void;
}