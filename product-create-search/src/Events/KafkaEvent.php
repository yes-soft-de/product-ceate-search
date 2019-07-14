<?php


namespace App\Events;

use App\BusinessLogic\SendToKafkaI;
use Symfony\Contracts\EventDispatcher\Event;

class KafkaEvent extends Event implements SendToKafkaI, KafkaEventI
{
    const NAME = 'kafka.event';
    private $sendToKafka;

    public function __construct(SendToKafkaI $sendToKafka)
    {
        $this->sendToKafka = $sendToKafka;
    }

    public function sendToKafka($status)
    {
        $this->sendToKafka->sendToKafka($status);
    }
}