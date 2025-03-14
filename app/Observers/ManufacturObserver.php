<?php

namespace App\Observers;

use App\Models\Manufactur;
use App\Notifications\LicenseExpiryNotification;
use Carbon\Carbon;

class ManufacturObserver
{
    public function updated(Manufactur $manufactur): void
    {
        $this->checkNotification($manufactur);
    }

    public function created(Manufactur $manufactur): void
    {
        $this->checkNotification($manufactur);
    }

    private function checkNotification(Manufactur $manufactur): void
    {
        $expiryDate = Carbon::parse($manufactur->last_installation_date);
        $now = now();

        $notifications = [
            ['days' => 90, 'field' => 'notify_90_days', 'notified' => 'is_notified_90'],
            ['days' => 30, 'field' => 'notify_30_days', 'notified' => 'is_notified_30'],
            ['days' => 7, 'field' => 'notify_7_days', 'notified' => 'is_notified_7'],
        ];

        foreach ($notifications as $notification) {
            if ($manufactur->{$notification['field']} && !$manufactur->{$notification['notified']}) {
                $daysBeforeExpiry = $expiryDate->copy()->subDays($notification['days']);

                if ($now->gte($daysBeforeExpiry)) {
                    $notifier = new LicenseExpiryNotification($manufactur, $notification['days']);
                    $notifier->send();

                    $manufactur->update([
                        $notification['notified'] => true
                    ]);
                }
            }
        }
    }
}
