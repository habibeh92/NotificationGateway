<?php

namespace App\NotificationDrivers;

interface DriverInterface
{

    /**
     * get slug of driver
     *
     * @return string
     */
    public static function index(): string;



    /**
     * send the msg
     *
     * @param string       $msg
     * @param string|array $receptor
     *
     * @return mixed
     */
    public function send(string $msg, string|array $receptor);



    /**
     * send the message
     *
     * @param string $msg
     * @param string $receptor
     *
     * @return mixed
     */
    public function sendOne(string $msg, string $receptor);



    /**
     * send the message to an array of receptors
     *
     * @param string $msg
     * @param array  $receptors
     *
     * @return mixed
     */
    public function sendBulk(string $msg, array $receptors);

}
