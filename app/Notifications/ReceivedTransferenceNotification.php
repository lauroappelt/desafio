<?php

namespace App\Notifications;

use App\Models\Transaction;
use App\Notifications\TransferenceNotificationInteface;
use Illuminate\Support\Facades\Log;

class ReceivedTransferenceNotification implements TransferenceNotificationInteface
{
    public function notify(Transaction $transaction): void
    {
        try {
            $transaction->destinationOperation->wallet->user->notify(new ReceivedTransference($transaction));

        } catch (\Exception $exception) {
            Log::error("Error sending notification: ", $exception->getMessage());
        }
    }
}
