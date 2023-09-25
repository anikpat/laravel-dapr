<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
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


    /**
     * Test Dapr Health endpoints
     */
    public function test_e2e_dapr_health(): void
    {
        $response = $this->get('/api/dapr/health');

        $response->assertStatus(200);
    }

    /**
     * Test success.
     */
    public function test_e2e_dapr_heatlth_failure(): void
    {
        Config::set('dapr.endpoint', 'http://localhost:4000');
        $response = $this->get('/api/dapr/health');

        Log::error($response->getContent());
        $response->assertStatus(500);
    }
}
