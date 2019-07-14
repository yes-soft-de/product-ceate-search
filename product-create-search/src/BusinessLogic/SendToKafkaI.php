<?php

namespace App\BusinessLogic;

interface SendToKafkaI
{
    public function sendToKafka($status);
}