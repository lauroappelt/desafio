<?php

namespace App\Services;

use App\Models\Transaction;
use App\Notifications\ExternalServiceNotification;
use App\Notifications\TransactionNotificationInteface;

class TransactionNotificationService
{
    public function __construct(
        private $notifications = []
    ) {
        $this->add(new ExternalServiceNotification());
    }

    public function add(TransactionNotificationInteface $notification): TransactionNotificationService
    {
        $this->notifications[] = $notification;
        return $this;
    }

    public function notify(Transaction $transaction): void
    {
        foreach ($this->notifications as $notification) {
            $notification->notify($transaction);
        }
    }
}
