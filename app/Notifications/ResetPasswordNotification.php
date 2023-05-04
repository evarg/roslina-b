<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Request;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = str_replace(
            [':token', ':email'],
            [
                $this->token,
                urlencode($notifiable->getEmailForPasswordReset()),
            ],
            Request::input('url')
        );

        return (new MailMessage())
            ->subject('Zmiana hasła dla roslina.com.pl')
            ->line('Otrzymałeś ten email, ponieważ zostało wysłane żądanie zmiany hasła z tego konta.')
            ->action('Zmień hasło:', url($url))
            ->line('Jeżeli nie Ty wysłałeś żądanie, nie wykonuj żadnej akcji.')
            ->salutation('Pozdrowienia, Zespół roslina.com.pl');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
