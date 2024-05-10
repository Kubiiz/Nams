<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class NewPassword extends Notification
{
    use Queueable;

    private $password, $name;

    /**
     * Create a new notification instance.
     */
    public function __construct($password, $name)
    {
        $this->password = $password;
        $this->name = $name;
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
                    ->subject(__('Created new password'))
                    ->greeting(__('Hello, :name!', ['name' => $this->name]))
                    ->line(__('You are receiving this email because your password has been changed.'))
                    ->action(__('Go to profile'), url('/'))
                    ->line(new HtmlString(__('Your new password: <strong>:password</strong>', ['password' => $this->password])));
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
