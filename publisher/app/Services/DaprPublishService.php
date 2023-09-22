<?php

namespace App\Services;

use App\Interfaces\DaprPublishServiceInterface;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DaprPublishService implements DaprPublishServiceInterface {

    public function sendMessage(String $message, String $type): bool
    {
        try {
            Http::withHeaders([
                "Content-Type" => "application/cloudevents+json"
            ])->post('http://localhost:3500/v1.0/publish/pubsub-topics/orders', [
                "specversion" => "1.0",
                "type" => $type,
                "source" => "testcloudeventspubsub",
                "subject" => "Message from publisher",
                "id" => "someCloudEventId",
                "time" => "2021-08-02T09:00:00Z",
                "datacontenttype" => "application/cloudevents+json",
                "data" => [
                    $message
                ]
            ]);
            return true;
        }
        catch (Exception $e) {
            $error = $e->getMessage();
            Log::error($error);
            return false;
        }
    }
}
