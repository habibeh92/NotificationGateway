<?php


namespace App\Channels;


use Illuminate\Notifications\Notification;

class SmsChannel
{

    /**
     * Send the given notification.
     *
     * @param mixed        $notifiable
     * @param Notification $notification
     *
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        return $notification->toSms($notifiable);
    }
}
