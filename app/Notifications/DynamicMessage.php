<?php

namespace App\Notifications;

use App\Channels\SmsChannel;
use App\Entities\AnonymousUser;
use App\Exceptions\NotificationDriverNotFound;
use App\Facades\Sms;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class DynamicMessage extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var string
     */
    private string $message;

    /**
     * @var string|null
     */
    private string|null $driver;

    /**
     * @var User
     */
    private User $user;



    /**
     * Create a new notification instance.
     *
     * @param string      $message
     * @param User        $user
     * @param string|null $driver
     */
    public function __construct(string $message, User $user, ?string $driver)
    {
        $this->message = $message;
        $this->user    = $user;
        $this->driver  = $driver;
    }



    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return [SmsChannel::class];
    }



    /**
     * send sms message to the notifiable
     *
     * @param Notifiable|AnonymousUser $notifiable
     *
     * @return mixed
     * @throws NotificationDriverNotFound
     */
    public function toSms($notifiable)
    {
        return Sms::user($this->user)->to($notifiable->mobile)->driver($this->driver)->send($this->message);
    }
}
