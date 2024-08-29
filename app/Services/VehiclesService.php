<?php

namespace App\Services;

use App\Repositories\Eloquents\VehiclesRepository;

class VehiclesService
{
    public function __construct(
        private VehiclesRepository $vehiclesRepository
    ) {}

    public function fetchAllVehicles()
    {
        return $this->vehiclesRepository->fetchAllVehicles();
    }
}