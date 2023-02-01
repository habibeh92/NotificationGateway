<?php

namespace App\Interfaces;

use App\Models\Notification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface NotificationRepositoryInterface
{


    /**
     * list of notifications
     *
     * @return Collection
     */
    public function list(): Collection;



    /**
     * create new notification
     *
     * @param array $data
     *
     * @return Notification
     */
    public function create(array $data): Notification;



    /**
     * get the paginated list of notifications and capable to filter receptor and driver
     *
     * @param string|null $receptor
     * @param string|null $driver
     *
     * @return LengthAwarePaginator
     */
    public function report(?string $receptor, ?string $driver): LengthAwarePaginator;
}
