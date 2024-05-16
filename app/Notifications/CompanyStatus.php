<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class CompanyStatus extends Notification
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
        $active = $this->result->active == 1 ? __('activated') : __('deactivated');
        $text = __('You received this email, because we <strong>:active</strong> your company (<strong>:company</strong>) in our website.', ['company' => $this->result->name, 'active' => $active]);

        $mail = (new MailMessage)
            ->greeting(__('Hello, :name :surname!', ['name' => $this->owner->name, 'surname' => $this->owner->surname]))
            ->subject(__('Service :active', ['active' => $active]))
            ->line(new HtmlString($text));

        if ($this->result->active == 1) {
            $mail = $mail
            ->action(__('Go to control panel'), route('panel.index'))
            ->line(__('Thanks for using our services!'));
        } else {
            $mail = $mail
            ->line(__('Thanks for using our services!'))
            ->line(__('If you want to use our services again, please write an email and you will be welcome back!'));
        }

        return $mail;
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
