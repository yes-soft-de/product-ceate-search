<?php


namespace App\Entity;


class ExtraData implements ExtraDataI
{
    private $topicName;
    private $status;

    public function getTopicName()
    {
        return $this->topicName;
    }

    public function setTopicName($topicName): void
    {
        $this->topicName = $topicName;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }
}