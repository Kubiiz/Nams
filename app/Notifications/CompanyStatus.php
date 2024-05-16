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
        $mail = (new MailMessage)
            ->subject(__('Company status - :name', ['name' => $this->result->name]))
            ->greeting(__('Hello, :name :surname!', ['name' => $this->owner->name, 'surname' => $this->owner->surname]));

        if ($this->result->active == 1) {
            $text = __('You received this email, because we <strong>activated</strong> your company (<strong>:company</strong>) in our website.', ['company' => $this->result->name]);

            $mail = $mail
            ->line(new HtmlString($text))
            ->action(__('Go to control panel'), route('panel.companies.edit', $this->result->id))
            ->line(__('Thanks for using our services!'));
        } else {
            $text = __('You received this email, because we <strong>deactivated</strong> your company (<strong>:company</strong>) in our website.', ['company' => $this->result->name]);

            $mail = $mail
            ->line(new HtmlString($text))
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
