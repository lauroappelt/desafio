<?php

namespace App\Services;

use App\Models\Transaction;
use App\Notifications\ExternalServiceNotification;
use App\Notifications\ReceivedTransferenceNotification;
use App\Notifications\SendTransferenceNotification;
use App\Notifications\TransferenceNotificationInteface;

class TransferenceNotificationService
{
    public function __construct(
        private $notifications = []
    ) {
        $this->add(new ExternalServiceNotification())
            ->add(new SendTransferenceNotification())
            ->add(new ReceivedTransferenceNotification());
    }

    public function add(TransferenceNotificationInteface $notification): TransferenceNotificationService
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
