<?php


namespace App\Listeners;


use App\Events\KafkaEventI;


class KafkaListener implements KafkaListenerI
{
    private  $kafkaEvent;
    private $status;

    public function __construct(KafkaEventI $kafkaEventI)
    {
        $this->kafkaEvent = $kafkaEventI;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function onKafkaEvent()
    {
        $this->kafkaEvent->sendToKafka($this->status);
    }
}