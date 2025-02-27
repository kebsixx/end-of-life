<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Filament\Notifications\Notification as FilamentNotification;
use App\Models\Manufactur;
use Carbon\Carbon;

class LicenseExpiryNotification extends Notification
{
    public function __construct(
        protected Manufactur $manufactur,
        protected int $daysBeforeExpiry
    ) {}

    public function via(object $notifiable): array
    {
        return []; // Kosongkan karena kita hanya menggunakan pop-up
    }

    public function send(): void
    {
        $expiryDate = Carbon::parse($this->manufactur->last_installation_date);
        $now = now();

        FilamentNotification::make()
            ->title('License Expiration Warning')
            ->body("License for {$this->manufactur->name} will expire in {$this->daysBeforeExpiry} days on {$expiryDate->format('d F Y')} (License Number: {$this->manufactur->license_number})")
            ->warning()
            ->persistent()
            ->send();
    }
}
