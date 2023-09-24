<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DaprE2ETest extends TestCase
{
    /**
     * Test success.
     */
    public function test_e2e_topic_message_publish(): void
    {
        $response = $this->post('/api/dapr/publish', [
            'orderId' => '1',
            'type' => 'create',
        ], [
            "Content-Type" => "application/cloudevents+json"
        ]);

        $response->assertStatus(200);
    }

    /**
     * Test failure for wrong validation type.
     */
    public function test_e2e_topic_message_failed_wrong_type(): void
    {
        $response = $this->post('/api/dapr/publish', [
            'orderId' => '1',
            'type' => 'test',
        ]);

        $response->assertJson([
            "message" => [
                "Type must be one of the following: create, cancel"
            ]
        ]);
    }

    /**
     * Test failure for missing order ID.
     */
    public function test_e2e_topic_message_failed_no_orderId(): void
    {
        $response = $this->post('/api/dapr/publish', [
            'type' => 'test',
        ]);

        $response->assertJson([
            "message" => [
                "Order ID is required"
            ]
        ]);
    }
}
