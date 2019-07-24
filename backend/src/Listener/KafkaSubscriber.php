<?php


namespace App\Listener;

use App\Service\SendToKafkaInterface;
use App\Event\KafkaEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class KafkaSubscriber implements EventSubscriberInterface
{
    private $sendToKafka;

    public function __construct(SendToKafkaInterface $sendToKafka)
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