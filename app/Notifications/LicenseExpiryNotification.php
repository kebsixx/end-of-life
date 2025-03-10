<?php

namespace App\Notifications;

use Carbon\Carbon;
use App\Models\Manufactur;
use Filament\Notifications\Actions\Action;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Notification as FilamentNotification;

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
            ->body("Peringatan! Produk {$this->manufactur->name} akan segera mencapai siklus hidupnya (End Of Life) dan tidak lagi didukung. Silakan menginstal atau memperbarui produk ini sebelum {$expiryDate->format('d F Y')} kedepan untuk memastikan kelanjutan penggunaan yang aman.")
            ->warning()
            ->persistent()
            ->actions([
                Action::make('view')
                    ->button()
                    ->url('/admin/manufacturs')
                    ->label('View Product')
            ])
            ->send();
    }
}
