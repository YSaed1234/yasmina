<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VendorApplicationReceivedNotification extends Notification
{
    use Queueable;

    private $vendor;

    /**
     * Create a new notification instance.
     */
    public function __construct($vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject(__('Vendor Application Received'))
                    ->greeting(__('Hello :name,', ['name' => $this->vendor->name]))
                    ->line(__('Thank you for applying to become a service provider on Yasmina.'))
                    ->line(__('Your application has been received and is currently under review by our team.'))
                    ->line(__('We will contact you soon for further coordination.'))
                    ->action(__('Visit Website', ['name' => config('app.name')]), url('/'))
                    ->line(__('Thank you for choosing us!'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => __('Application Received'),
            'message' => __('Your vendor application has been submitted successfully and is under review.'),
            'vendor_id' => $this->vendor->id,
            'type' => 'vendor_application',
        ];
    }
}
