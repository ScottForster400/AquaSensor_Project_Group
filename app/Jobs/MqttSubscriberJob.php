<?php

namespace App\Jobs;

use Laravel\Reverb\Loggers\Log;
use PhpMqtt\Client\Facades\MQTT;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class MqttSubscriberJob implements ShouldQueue
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

        //Log::info("Connected Bruhbuerhwue");
        Log::error("ahhhahahahahahh");


        // try{
        //     $mqtt = MQTT:: connection();

        //     $mqtt->subscribe('sensor/#', function(string $topic, string $message) use ($mqtt){
        //         Log::info("Recieved message on topic: '{$topic}': {$message}");

        //         try {
        //            // broadcast(new MessageReceived($message));
        //         }
        //         catch(\Exception $e){
        //             Log::error('Failed to broadcast event: '. $e->getMessage());
        //         }
        //         $mqtt->interrupt();

        //     },0);

        //     $mqtt->loop(true);
        //     $mqtt->disconnect();
        // }
        // catch (MqttClientException $e){
        //     Log::error("An error occurred while subscribing".$e->getMessage());
        //}

    }
}
