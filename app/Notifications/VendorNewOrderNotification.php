<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VendorNewOrderNotification extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('vendor.orders.show', $this->order->id);

        return (new MailMessage)
            ->subject(__('New Order Received - Order #:id', ['id' => $this->order->id]))
            ->greeting(__('Hello :name,', ['name' => $notifiable->name]))
            ->line(__('You have received a new order on Yasmina.'))
            ->line(__('Order #:id', ['id' => $this->order->id]))
            ->line(__('Customer: :name', ['name' => $this->order->user->name]))
            ->line(__('Total: :total', ['total' => number_format($this->order->total, 2) . ' ' . __('LE')]))
            ->action(__('View Order Details'), $url)
            ->line(__('Thank you for using our platform!'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'message' => __('New order #:id received from :customer. Total: :total', [
                'id' => $this->order->id,
                'customer' => $this->order->user->name,
                'total' => number_format($this->order->total, 2)
            ]),
            'action_url' => route('vendor.orders.show', $this->order->id),
        ];
    }
}
