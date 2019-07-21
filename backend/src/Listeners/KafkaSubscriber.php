<?php


namespace App\Listeners;

use App\BusinessLogic\SendToKafkaI;
use App\Events\KafkaEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class KafkaSubscriber implements EventSubscriberInterface
{
    private $sendToKafka;

    public function __construct(SendToKafkaI $sendToKafka)
    {
        $this->sendToKafka = $sendToKafka;
    }

    public static function getSubscribedEvents()
    {
        return [
            KafkaEvent::NAME => "onKafkaEvent"
        ];
    }

    public function onKafkaEvent()
    {
       $this->sendToKafka->sendToKafka();
    }
}