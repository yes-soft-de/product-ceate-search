<?php


namespace App\Listener;

use App\Event\KafkaEvent;
use App\Manager\SendToKafkaInterface;
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
            KafkaEvent::class => "onKafkaEvent"
        ];
    }

    public function onKafkaEvent(KafkaEvent $event)
    {
       $this->sendToKafka->sendToKafka($event->getTopicName(), $event->getStatus());
    }
}