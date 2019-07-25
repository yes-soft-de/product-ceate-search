<?php


namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class KafkaEvent extends Event
{
    private $status;
    private $topicName;

    /**
     * KafkaEvent constructor.
     * @param string $status
     * @param string $topicName
     */
    public function __construct(string $topicName, string $status)
    {
        $this->status = $status;
        $this->topicName = $topicName;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getTopicName()
    {
        return $this->topicName;
    }

    public function setTopicName($topicName): void
    {
        $this->topicName = $topicName;
    }
}