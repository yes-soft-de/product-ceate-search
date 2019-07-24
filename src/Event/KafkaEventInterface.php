<?php

namespace App\Event;

interface KafkaEventInterface
{
    public function getStatus();

    public function setStatus($status);

    public function getTopicName();

    public function setTopicName($topicName): void;
}