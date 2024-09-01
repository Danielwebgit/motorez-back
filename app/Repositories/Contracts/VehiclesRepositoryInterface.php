<?php

namespace App\Repositories\Contracts;

interface VehiclesRepositoryInterface
{
    public function fetchAllVehicles();
    public function updateVehicle($formVehicle, $vehicleId);
    public function deleteVehicle($vehicleId);
    public function importDataVehicles(array $data, $extension);
}