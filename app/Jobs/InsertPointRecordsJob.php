<?php

namespace App\Jobs;

use App\Models\PointRecord;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InsertPointRecordsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    # Variables
    protected DateTime $time;
    protected float $latitude;
    protected float $longitude;
    protected string $selfie;

    /**
     * Create a new job instance.
     */

    public function __construct($args)
    {
        $this->time = new DateTime($args['time']);
        $this->latitude = $args['latitude'];
        $this->longitude = $args['longitude'];
        if (isset($args['selfie'])) {
            $this->selfie = $args['selfie'];
        }
    }

    /**
     * Execute the job.
     */

    public function handle(): void
    {
        $dataToInsert = array(
            'time' => $this->time,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'selfie' => isset($this->selfie) ? $this->selfie : null
        );
        PointRecord::create($dataToInsert);
    }
}
