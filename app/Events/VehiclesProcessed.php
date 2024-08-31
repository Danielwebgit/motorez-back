<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VehiclesProcessed
{
    use Dispatchable, SerializesModels;

    public $totalVehicles;

    /**
     * Create a new event instance.
     *
     * @param int $totalVehicles
     * @return void
     */
    public function __construct(int $totalVehicles)
    {
        $this->totalVehicles = $totalVehicles;
    }
}
