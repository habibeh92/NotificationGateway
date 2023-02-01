<?php

namespace App\NotificationDrivers;


use App\Exceptions\NotificationSendingFailed;

abstract class DriverAbstract implements DriverInterface
{
    protected array $configs;



    /**
     * the DriverAbstract constructor
     */
    public function __construct()
    {
        $this->configs = $this->resolveConfigs();
    }



    /**
     * @inheritDoc
     */
    public function resolveConfigs(): array
    {
        return config("notification.drivers." . static::index());
    }



    /**
     * get the config value
     *
     * @param string $key
     * @param null   $default
     *
     * @return mixed|null
     */
    public function config(string $key, $default = null)
    {
        if (isset($this->configs[$key])) {
            return $this->configs[$key];
        }

        return $default;
    }



    /**
     * @inheritDoc
     * @throws NotificationSendingFailed
     */
    public function send(string $msg, string|array $receptor)
    {
        if (is_array($receptor)) {
            try {
                return $this->sendBulk($msg, $receptor);
            } catch (\Exception $e) {
                throw new NotificationSendingFailed("Notification can not be sent!");
            }
        }
        try {
            return $this->sendOne($msg, $receptor);
        } catch (\Exception $e) {
            throw new NotificationSendingFailed("Notification can not be sent!");
        }
    }


}
