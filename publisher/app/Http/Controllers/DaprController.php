<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DaprController extends Controller
{
    //
    public function DaprPublishMessage() {
        Http::withHeaders([
            "Content-Type" => "application/cloudevents+json"
        ])->post('http://localhost:3500/v1.0/publish/otodapr-pubsub-topics/orders', [
            "specversion" => "1.0",
            "type" => "create",
            "source" => "testcloudeventspubsub",
            "subject" => "Message from publisher",
            "id" => "someCloudEventId",
            "time" => "2021-08-02T09:00:00Z",
            "datacontenttype" => "application/cloudevents+json",
            "data" => [
                "orderId" => "100"
            ]
        ]);
    }
}
