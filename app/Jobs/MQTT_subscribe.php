<?php

namespace App\Jobs;

use Symfony\Component\Process\Process;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class MQTT_subscribe implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $process = new Process(['python3','/public/scripts/mqtt_subscribe.py']);
        $process->run();
    }
}
