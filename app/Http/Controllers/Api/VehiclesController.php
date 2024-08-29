<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Services\VehiclesService;

class VehiclesController extends Controller
{

    public function __construct(private VehiclesService $vehiclesService) 
    {}
   
    public function fetchAllVehicles()
    {
        return $this->vehiclesService->fetchAllVehicles();
    }
}
