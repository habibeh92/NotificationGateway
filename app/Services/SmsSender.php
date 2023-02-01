<?php

namespace App\Services;


use App\Exceptions\NotificationDriverNotFound;
use App\Interfaces\NotificationRepositoryInterface;
use App\Models\Driver;
use App\Models\User;
use App\NotificationDrivers\DriverInterface;

class SmsSender
{
    /**
     * @var DriverInterface
     */
    private $driver;

    /**
     * @var string|array
     */
    private $receptor;

    /**
     * @var string
     */
    private $from;

    /**
     * @var User
     */
    private User $user;

    /**
     * @var NotificationRepositoryInterface
     */
    private NotificationRepositoryInterface $notification_repository;



    /**
     * SmsSender constructor.
     *
     * @param NotificationRepositoryInterface $notification_repository
     *
     * @throws NotificationDriverNotFound
     */
    public function __construct(NotificationRepositoryInterface $notification_repository)
    {
        $this->driver                  = $this->resolveDriver();
        $this->notification_repository = $notification_repository;
    }



    /**
     * set the driver property
     *
     * @param string|null $driver
     *
     * @return SmsSender
     * @throws NotificationDriverNotFound
     */
    public function driver(?string $driver)
    {
        $this->driver = $this->resolveDriver($driver);
        return $this;
    }



    /**
     * set the from property
     *
     * @param string $from
     *
     * @return SmsSender
     */
    public function from(string $from)
    {
        $this->from = $from;
        return $this;
    }



    /**
     * set the receptor property
     *
     * @param string|array $receptor
     *
     * @return SmsSender
     */
    public function to(string|array $receptor)
    {
        $this->receptor = $receptor;

        return $this;
    }



    /**
     * set the user property
     *
     * @param User $user
     *
     * @return SmsSender
     */
    public function user(User $user)
    {
        $this->user = $user;
        return $this;
    }



    /**
     * execute the sending message
     *
     * @param string $message
     *
     * @return mixed
     */
    public function send(string $message)
    {
        $this->driver->send($message, $this->receptor);
        return $this->notification_repository->create([
            "user_id"  => $this->user->id,
            "driver"   => $this->driver::index(),
            "message"  => $message,
            "receptor" => $this->receptor,
        ]);
    }



    /**
     * resolve the driver
     *
     * @param DriverInterface|string|null $driver
     *
     * @return DriverInterface
     * @throws NotificationDriverNotFound
     */
    private function resolveDriver(DriverInterface|string|null $driver = null): DriverInterface
    {
        if ($driver instanceof DriverInterface) {
            return $driver;
        }

        if (!$driver) {
            $driver = config("notification.default");
        }

        $class = config("notification.drivers.$driver.class");
        if (class_exists($class)) {
            $driver_class = new $class();
            if ($driver_class instanceof DriverInterface) {
                return $driver_class;
            }
        }

        throw new NotificationDriverNotFound("Notification driver `$driver` not found!");
    }
}
