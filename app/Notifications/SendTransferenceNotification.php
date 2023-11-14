<?php

namespace App\Notifications;

use App\Models\Transaction;
use App\Notifications\TransferenceNotificationInteface;
use Illuminate\Support\Facades\Log;

class SendTransferenceNotification implements TransferenceNotificationInteface
{
    public function notify(Transaction $transaction): void
    {
        try {
            $transaction->originOperation->wallet->user->notify(new SendTransference($transaction));

        } catch (\Exception $exception) {
            Log::error("Error sending notification: ", $exception->getMessage());
        }
    }
}
