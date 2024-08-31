<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportRequest;
use App\Services\FileImportsDataVehiclesService;

class FileImportsDataVehiclesController extends Controller
{

    public function __construct(private FileImportsDataVehiclesService $fileImportsDataVehiclesService) 
    {}

    public function fileImportsDataVehicles(ImportRequest $request)
    {
        return $this->fileImportsDataVehiclesService->fileImportsDataVehicles($request);
    }
}
