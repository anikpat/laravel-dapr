<?php

namespace App\Services;

use App\Interfaces\DaprServiceInterface;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DaprService implements DaprServiceInterface {

    private string $daprEndpoint;
    public function __construct() {
        $this->daprEndpoint = Config::get('dapr.endpoint');
    }

    /**
     * @param mixed $message
     * @param String $type
     * @return bool
     * Publish message to a given topic
     */
    public function sendTopicMessage(String $topicName, mixed $message, String $type): bool
    {
        try {
            Http::withHeaders([
                "Content-Type" => "application/cloudevents+json"
            ])->post($this->daprEndpoint.'/v1.0/publish/pubsub-topics/'.$topicName, [
                "specversion" => "1.0",
                "type" => $type,
                "source" => "publisherService",
                "subject" => "Message from publisher",
                "id" => Str::uuid()->toString(),
                "time" => Date::now('UTC'),
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

    /**
     * @param String $queueName
     * @param mixed $message
     * @param String $type
     * @return bool
     * Send Queue Message to a given queue
     */
    public function sendQueueMessage(String $queueName, mixed $message, String $type): bool {
        try {
            Http::withHeaders([
                "Content-Type" => "application/cloudevents+json"
            ])->post($this->daprEndpoint.'/v1.0/publish/pubsub-queues/'.$queueName, [
                "specversion" => "1.0",
                "type" => $type,
                "source" => "publisherService",
                "subject" => "Message from publisher",
                "id" => Str::uuid()->toString(),
                "time" => Date::now('UTC'),
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

    /**
     * @param mixed $message
     * @param String $type
     * @return bool
     * Send Queue Message to a given queue
     */
    public function sendRestRequest(mixed $message, String $type) {
        try {
            $request = Http::withHeaders([
                        "Content-Type" => "application/cloudevents+json"
                    ])->post($this->daprEndpoint.'/v1.0/invoke/consumer/method/api/dapr/rest', [
                        "specversion" => "1.0",
                        "type" => $type,
                        "source" => "publisherService",
                        "subject" => "Message from publisher",
                        "id" => Str::uuid()->toString(),
                        "time" => Date::now('UTC'),
                        "datacontenttype" => "application/cloudevents+json",
                        "data" => [
                            $message
                        ]
                    ]);
            Log::error($request);
            return $request->getBody();
        }
        catch (Exception $e) {
            $error = $e->getMessage();
            Log::error($error);
            return false;
        }
    }


    public function getDaprHealth(): bool
    {
        try {
            $response = Http::get($this->daprEndpoint.'/v1.0/healthz');
            if($response->status() === 204) {
                return true;
            }
            return false;

        } catch (Exception $e) {
            $error = $e->getMessage();
            Log::error($error);
            return false;
        }
    }
}
