<?php

use App\Models\Transaction;

use App\Notifications\TransactionNotificationInteface;

class TransactionNotification
{
    public function __construct(
        private $notifications = []
    ) {
    }

    public function add(TransactionNotificationInteface $notification): TransactionNotificationService
    {
        $this->notifications[] = $notification;
        return $this;
    }

    public function validate(Transaction $transaction): void
    {
        foreach ($this->notifications as $notification) {
            $notification->validate($transaction);
        }
    }
}
