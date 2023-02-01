<?php

namespace App\NotificationDrivers;


use App\Exceptions\NotificationDriverNotFound;

class GhasedakDriver extends DriverAbstract
{
    /**
     * @inheritDoc
     */
    public static function index(): string
    {
        return "ghasedak";
    }



    /**
     * @inheritDoc
     */
    public function sendOne(string $msg, string $receptor)
    {
        $url = $this->config("url") . "/simple";
        $this->execute($url, $msg, $receptor);
    }



    /**
     * @inheritDoc
     */
    public function sendBulk(string $msg, array $receptors)
    {
        $url = $this->config("url") . "/bulk";
        $this->execute($url, $msg, $receptors);
    }



    /**
     * curl to ghasedak panel
     *
     * @param string       $url
     * @param string       $msg
     * @param string|array $receptor
     *
     * @return string
     * @throws NotificationDriverNotFound
     */
    private function execute($url, $msg, $receptor)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL           => $url,
            CURLOPT_HTTP_VERSION  => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS    => http_build_query([
                "message"  => $msg,
                "sender"   => $this->config("sender"),
                "receptor" => $receptor,
            ]),
            CURLOPT_HTTPHEADER    => [
                "apikey: " . $this->config("apikey"),
            ],
        ]);
        $response = curl_exec($curl);
        $err      = curl_error($curl);
        curl_close($curl);

        if ($err) {
            throw new NotificationDriverNotFound("Notification can not be sent!");
        }

        return $response;
    }
}
