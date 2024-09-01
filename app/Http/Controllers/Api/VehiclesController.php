<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleRequest;
use App\Services\VehiclesService;

class VehiclesController extends Controller
{

    public function __construct(private VehiclesService $vehiclesService) 
    {}
   
    public function fetchAllVehicles()
    {
        return $this->vehiclesService->fetchAllVehicles();
    }

    public function updateVehicle(VehicleRequest $request, $vehicleId)
    {
        $vehicleId = request()->route('vehicleId');
        return $this->vehiclesService->updateVehicle($request->input(), $vehicleId);
    }

    public function deleteVehicle($vehicleId)
    {
        $vehicleId = request()->route('vehicleId');
        return $this->vehiclesService->deleteVehicle($vehicleId);
    }
}
