<?php

namespace App\Notifications;

use App\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VendorApprovedNotification extends Notification
{
    use Queueable;

    public function __construct(public Vendor $vendor) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your NovaVault Vendor Account is Approved!')
            ->greeting("Congratulations, {$this->vendor->business_name}!")
            ->line('Your vendor account has been reviewed and approved.')
            ->line('You can now set up your store, add products, and start accepting orders.')
            ->action('Go to Dashboard', url('/vendor/dashboard'))
            ->line('Welcome to NovaVault.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'vendor_approved',
            'vendor_id' => $this->vendor->id,
            'message' => "Your vendor account \"{$this->vendor->business_name}\" has been approved.",
        ];
    }
}
