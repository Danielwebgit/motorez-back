<?php

namespace App\Factories;

use App\Repositories\Contracts\VehiclesRepositoryInterface;
use App\Services\FileImportsDataVehiclesService;

class FileImportsDataVehiclesFactory
{
    public static function create(): FileImportsDataVehiclesService
    {
        $fileImportsDataVehicle = app(VehiclesRepositoryInterface::class);

        return new FileImportsDataVehiclesService($fileImportsDataVehicle);
    }
}
