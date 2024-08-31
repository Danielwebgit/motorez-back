<?php

namespace App\Jobs;

use App\Events\VehiclesProcessed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessVehiclesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $vehicles;
    protected $batchSize;

    /**
     * Create a new job instance.
     */
    public function __construct(array $vehicles, int $batchSize = 10)
    {
        $this->vehicles = $vehicles;
        $this->batchSize = $batchSize;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $totalVehicles = count($this->vehicles);

        for ($i = 0; $i < $totalVehicles; $i += $this->batchSize) {
            $batch = array_slice($this->vehicles, $i, $this->batchSize);

            DB::table('vehicles')->insert($batch);
        }

        event(new VehiclesProcessed($totalVehicles));
    }
}
