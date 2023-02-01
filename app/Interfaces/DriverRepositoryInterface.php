<?php

namespace App\Interfaces;

use App\Models\Driver;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface DriverRepositoryInterface
{


    /**
     * list of drivers
     *
     * @return Collection
     */
    public function list(): Collection;



    /**
     * create new sriver
     *
     * @param array $data
     *
     * @return Driver
     */
    public function create(array $data): Driver;



    /**
     * find the driver
     *
     * @param string $slug
     *
     * @return Driver
     */
    public function getDriver($slug);


}
