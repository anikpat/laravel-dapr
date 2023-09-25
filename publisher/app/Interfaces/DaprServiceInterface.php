<?php

namespace App\Interfaces;

interface DaprServiceInterface
{
    /**
     * @param mixed $message
     * @param String $type
     * @return bool
     * Publish message to a given topic
     */
    public function sendTopicMessage(String $topicName, mixed $message, String $type): bool;

    /**
     * @param String $queueName
     * @param mixed $message
     * @param String $type
     * @return bool
     * Send Queue Message to a given queue
     */
    public function sendQueueMessage(String $queueName, mixed $message, String $type): bool;


    /**
     * @return int|string
     * Get Dapr Health
     */
    public function getDaprHealth(): bool;
}
