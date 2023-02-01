<?php

namespace App\NotificationDrivers;


use Kavenegar\KavenegarApi;

class KavenegarDriver extends DriverAbstract
{


    /**
     * @inheritDoc
     */
    public static function index(): string
    {
        return "kavenegar";
    }



    /**
     * @inheritDoc
     */
    public function sendOne(string $msg, string $receptor)
    {
        return $this->service()->Send($this->config("sender"), $receptor, $msg);
    }



    /**
     * @inheritDoc
     */
    public function sendBulk(string $msg, array $receptors)
    {
        return $this->service()->SendArray($this->config("sender"), $receptors, $msg);

    }



    /**
     * get the kavenegar api instance
     *
     * @return KavenegarApi
     */
    private function service(): KavenegarApi
    {
        return new KavenegarApi($this->config("apikey", ""));
    }

}
