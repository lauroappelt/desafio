<?php

namespace App\Notifications;

use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Notifications\TransactionNotificationInteface;

class ExternalServiceNotification implements TransactionNotificationInteface
{
    public function notify(Transaction $transaction): void
    {
        try {
            $notification = Http::get('https://run.mocky.io/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6');
        } catch (\Exception $exception) {
            Log::error("Error sending notification: ", $exception->getMessage());
        }
    }
}
