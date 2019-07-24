<?php

namespace App\Entity;

interface ExtraDataInterface
{
    public function getTopicName();

    public function setTopicName($topicName): void;

    public function getStatus();

    public function setStatus($status): void;
}