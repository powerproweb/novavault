<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowStockAlertNotification extends Notification
{
    use Queueable;

    public function __construct(public Product $product) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Low Stock Alert: {$this->product->title}")
            ->line("**{$this->product->title}** is running low on stock.")
            ->line("Current stock: {$this->product->backstock_qty} (threshold: {$this->product->low_stock_threshold})")
            ->action('Manage Products', url('/vendor/products'))
            ->line('Consider restocking soon.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'low_stock_alert',
            'product_id' => $this->product->id,
            'product_title' => $this->product->title,
            'current_stock' => $this->product->backstock_qty,
        ];
    }
}
