<?php


namespace App\Facades;


use App\Models\Notification;
use App\Models\User;
use App\Services\SmsSender;
use Illuminate\Support\Facades\Facade;

/**
 * @method static SmsSender user(User $user)
 * @method static SmsSender to(string $mobile)
 * @method static SmsSender from(string $mobile)
 * @method static SmsSender driver(string $driver)
 * @method static Notification send(string $message)
 */
class Sms extends Facade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor()
    {
        return "sms";
    }
}
