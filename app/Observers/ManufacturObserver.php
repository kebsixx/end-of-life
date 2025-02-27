<?php

namespace App\Observers;

use App\Models\Manufactur;
use App\Models\User;
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
        if ($manufactur->is_notified) {
            return;
        }

        $expiryDate = Carbon::parse($manufactur->last_installation_date);
        $notifyDate = $this->calculateNotifyDate($manufactur);

        if (now()->gte($notifyDate)) {
            // Send notification to all users
            User::all()->each(function ($user) use ($manufactur) {
                $user->notify(new LicenseExpiryNotification($manufactur));
            });

            $manufactur->update(['is_notified' => true]);
        }
    }

    private function calculateNotifyDate($manufactur): Carbon
    {
        $expiryDate = Carbon::parse($manufactur->last_installation_date);

        $days = match ($manufactur->notification_period) {
            '1 day' => 1,
            '3 days' => 3,
            '1 week' => 7,
            '2 weeks' => 14,
            default => 7,
        };

        return $expiryDate->copy()->subDays($days);
    }
}
