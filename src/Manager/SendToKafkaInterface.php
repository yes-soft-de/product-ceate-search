<?php

namespace App\Manager;

interface SendToKafkaInterface
{
    public function sendToKafka($topicName, $status);
}