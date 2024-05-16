<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class NewCompany extends Notification
{
    use Queueable;

    private $result, $owner;

    /**
     * Create a new notification instance.
     */
    public function __construct($result, $owner)
    {
        $this->result = $result;
        $this->owner = $owner;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject(__('New service - :name', ['name' => $this->result->name]))
                    ->greeting(__('Hello, :name :surname!', ['name' => $this->owner->name, 'surname' => $this->owner->surname]))
                    ->line(new HtmlString(__('You received this email, because we created a new service for your company (<strong>:company</strong>) in our website.', ['company' => $this->result->name])))
                    ->action(__('Go to control panel'), route('panel.companies.edit', $this->result->id))
                    ->line(__('Thanks for using our services!'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
