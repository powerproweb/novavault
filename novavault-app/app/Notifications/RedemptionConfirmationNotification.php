<?php

namespace App\Notifications;

use App\Models\Redemption;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RedemptionConfirmationNotification extends Notification
{
    use Queueable;

    public function __construct(public Redemption $redemption) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Redemption Confirmed — Code: {$this->redemption->confirmation_code}")
            ->line("Your reward redemption at **{$this->redemption->vendor->business_name}** is confirmed.")
            ->line("Type: {$this->redemption->reward_type}")
            ->line("Tokens used: {$this->redemption->amount}")
            ->line("**Confirmation Code: {$this->redemption->confirmation_code}**")
            ->action('View Redemption History', url('/patron/redemptions'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'redemption_confirmation',
            'redemption_id' => $this->redemption->id,
            'confirmation_code' => $this->redemption->confirmation_code,
            'amount' => $this->redemption->amount,
        ];
    }
}
