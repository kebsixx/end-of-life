<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Filament\Notifications\Notification as FilamentNotification;
use App\Models\Manufactur;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LicenseExpiryNotification extends Notification
{
    public function __construct(
        protected Manufactur $manufactur,
        protected int $daysBeforeExpiry
    ) {}

    public function via(object $notifiable): array
    {
        return ['database']; // Store notifications in database
    }

    public function send(): void
    {
        $expiryDate = Carbon::parse($this->manufactur->last_installation_date);
        $now = now();

        // Log notification attempt
        Log::info('License expiry notification sent', [
            'product' => $this->manufactur->name,
            'expiry_date' => $expiryDate->format('Y-m-d H:i:s'),
            'sent_at' => $now->format('Y-m-d H:i:s')
        ]);

        FilamentNotification::make()
            ->title('License Expiration Warning')
            ->body("Peringatan! Produk {$this->manufactur->name} akan segera mencapai siklus hidupnya (End Of Life) dan tidak lagi didukung. Silakan menginstal atau memperbarui produk ini sebelum {$expiryDate->format('d F Y')} kedepan untuk memastikan kelanjutan penggunaan yang aman.")
            ->warning()
            ->persistent()
            ->send();
    }
}
