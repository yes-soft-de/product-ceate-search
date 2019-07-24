<?php


namespace App\Event;

use App\Service\SendToKafkaInterface;
use App\Entity\ExtraDataInterface;
use Symfony\Contracts\EventDispatcher\Event;

class KafkaEvent extends Event implements KafkaEventInterface
{
    const NAME = 'kafka.event';
    private $extraData;
    private $status;
    private $topicName;

    public function __construct(ExtraDataInterface $extraData)
    {
        $this->extraData = $extraData;
        $this->status = $extraData->getStatus();
        $this->topicName = $extraData->getTopicName();
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->extraData->setStatus($status);
    }

    public function getTopicName()
    {
        return $this->topicName;
    }

    public function setTopicName($topicName): void
    {
        $this->extraData->setTopicName($topicName);
    }
}