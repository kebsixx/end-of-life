<?php

namespace App\Observers;

use App\Models\Version;
use Carbon\Carbon;
use Filament\Notifications\Notification;

class VersionObserver
{
    public function updated(Version $version): void
    {
        $this->checkNotification($version);
    }

    public function created(Version $version): void
    {
        $this->checkNotification($version);
    }

    private function checkNotification(Version $version): void
    {
        $expiryDate = Carbon::parse($version->expiry_date);
        $now = now();

        $notifications = [
            ['days' => 90, 'field' => 'notify_90_days', 'notified' => 'is_notified_90'],
            ['days' => 30, 'field' => 'notify_30_days', 'notified' => 'is_notified_30'],
            ['days' => 7, 'field' => 'notify_7_days', 'notified' => 'is_notified_7'],
        ];

        foreach ($notifications as $notification) {
            if ($version->{$notification['field']} && !$version->{$notification['notified']}) {
                $daysBeforeExpiry = $expiryDate->copy()->subDays($notification['days']);

                if ($now->gte($daysBeforeExpiry)) {
                    // Send notification directly using Filament Notification
                    Notification::make()
                        ->title('Version Expiration Warning')
                        ->body("Warning! Version {$version->version_name} ({$version->version_number}) will reach its End of Life in {$notification['days']} days. Please update to a newer version before {$expiryDate->format('d F Y')}.")
                        ->warning()
                        ->persistent()
                        ->send();

                    $version->update([
                        $notification['notified'] => true
                    ]);
                }
            }
        }
    }
}
