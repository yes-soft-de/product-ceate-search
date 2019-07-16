<?php

namespace App\Events;

interface KafkaEventI
{

    public function sendToKafka($status);

}