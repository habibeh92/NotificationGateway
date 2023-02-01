<?php


namespace App\Entities;


use Illuminate\Notifications\AnonymousNotifiable;

/**
 * Class AnonymousUser
 * To be used as notifiable in notifications
 *
 * @package App\Entities
 */
class AnonymousUser extends AnonymousNotifiable
{
    /**
     * @var string
     */
    public string $mobile;



    /**
     * AnonymousUser constructor.
     *
     * @param string $mobile
     */
    public function __construct(string $mobile)
    {
        $this->mobile = $mobile;
    }
}
