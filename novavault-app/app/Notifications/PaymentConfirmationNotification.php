<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentConfirmationNotification extends Notification
{
    use Queueable;

    public function __construct(public Order $order) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Order #{$this->order->id} Confirmed — \${$this->order->total}")
            ->line("Your order at **{$this->order->vendor->business_name}** has been confirmed.")
            ->line("Total: \${$this->order->total}")
            ->action('View Order', url("/store/{$this->order->vendor->slug}/order/{$this->order->id}"))
            ->line('Thank you for your purchase!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'payment_confirmation',
            'order_id' => $this->order->id,
            'total' => $this->order->total,
            'vendor_name' => $this->order->vendor->business_name,
        ];
    }
}
