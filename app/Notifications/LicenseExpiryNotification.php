<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Filament\Notifications\Notification as FilamentNotification;
use App\Models\Manufactur;
use Carbon\Carbon;

class LicenseExpiryNotification extends Notification
{
    public function __construct(protected Manufactur $manufactur) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $expiryDate = Carbon::parse($this->manufactur->last_installation_date);
        $now = now();

        // Menggunakan abs() untuk nilai absolut dan ceil() untuk pembulatan ke atas
        $daysLeft = ceil(abs($now->diffInDays($expiryDate)));

        $status = $now->gt($expiryDate) ? 'expired' : 'will expire';

        return FilamentNotification::make()
            ->title('License Expiration Warning')
            ->body("License for {$this->manufactur->name} {$status} in {$daysLeft} days. (License: {$this->manufactur->license_number})")
            ->warning()
            ->getDatabaseMessage();
    }
}
