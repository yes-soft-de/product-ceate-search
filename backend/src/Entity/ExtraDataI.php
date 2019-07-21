<?php

namespace App\Entity;

interface ExtraDataI
{
    public function getTopicName();

    public function setTopicName($topicName): void;

    public function getStatus();

    public function setStatus($status): void;
}