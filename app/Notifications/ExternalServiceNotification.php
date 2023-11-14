<?php

namespace App\Notifications;

use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalServiceNotification implements TransferenceNotificationInteface
{
    public function notify(Transaction $transaction): void
    {
        try {
            $notificationRequest = Http::get('https://run.mocky.io/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6');

            if ($notificationRequest->status() != 200) {
                throw new Exception("External notification failed");
            }

        } catch (\Exception $exception) {
            Log::error("Error sending notification: ", $exception->getMessage());
        }
    }
}
