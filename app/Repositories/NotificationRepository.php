<?php

namespace App\Repositories;

use App\Interfaces\NotificationRepositoryInterface;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class NotificationRepository implements NotificationRepositoryInterface
{

    /**
     * @var Notification
     */
    protected Notification $model;



    /**
     * NotificationRepository constructor
     *
     * @param Notification $notification
     */
    public function __construct(Notification $notification)
    {
        $this->model = $notification;
    }



    /**
     * @inheritDoc
     */
    public function list(): Collection
    {
        return $this->model->all();
    }



    /**
     * @inheritDoc
     */
    public function create(array $data): Notification
    {
        return $this->model = $this->model->create($data);
    }



    /**
     * @inheritDoc
     */
    public function report($receptor, $driver): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        /** @var Builder $builder */
        $builder = Notification::whereNotNull("id");//to continue query on builder

        if ($receptor) {
            $builder->where("receptor", $receptor);
        }

        if ($driver) {
            $builder->where("driver", $driver);
        }

        return $builder->paginate(10);
    }
}
