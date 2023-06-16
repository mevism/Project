<?php

namespace Modules\Application\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\AfricasTalking\AfricasTalkingChannel;
use NotificationChannels\AfricasTalking\AfricasTalkingMessage;

class SMS extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public function __construct($verification_code)
    {
        $this->verification_code = $verification_code;
    }

    public function via($notifiable)
    {
        return [AfricasTalkingChannel::class];
    }

    public function toAfricasTalking($notifiable)
    {
        return (new AfricasTalkingMessage())
            ->content('Welcome to TUM online course application platform. Your verification code '. $this->verification_code. '. Please do not share this code with anyone.');

    }


}
