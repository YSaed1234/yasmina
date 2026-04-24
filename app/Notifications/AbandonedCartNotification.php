<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AbandonedCartNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
        return (new MailMessage)
            ->subject(__('Don\'t forget your pieces!'))
            ->greeting(__('Hello :name,', ['name' => $notifiable->name]))
            ->line(__('We noticed you left some beautiful items in your shopping bag.'))
            ->line(__('They are waiting for you to make them yours.'))
            ->action(__('Return to Bag'), url(route('web.cart')))
            ->line(__('Thank you for shopping with Yasmina!'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => __('Abandoned Cart Reminder'),
            'message' => __('You have items in your shopping bag waiting for you.'),
            'action_url' => route('web.cart'),
            'type' => 'abandoned_cart'
        ];
    }
}
