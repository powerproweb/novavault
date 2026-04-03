<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TokensEarnedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $amount,
        public string $vendorName,
        public int $orderId,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("You earned {$this->amount} tokens at {$this->vendorName}!")
            ->line("You just earned **{$this->amount}** loyalty tokens from your purchase at **{$this->vendorName}**.")
            ->line("Order #{$this->orderId}")
            ->action('View Your Wallet', url('/patron/wallets'))
            ->line('Keep earning and redeeming rewards!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'tokens_earned',
            'amount' => $this->amount,
            'vendor_name' => $this->vendorName,
            'order_id' => $this->orderId,
        ];
    }
}
