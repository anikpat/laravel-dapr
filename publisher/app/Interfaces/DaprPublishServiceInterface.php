<?php

namespace App\Interfaces;

interface DaprPublishServiceInterface
{
    public function sendMessage(String $message, String $type): bool;
}
