<?php

namespace App\Listeners;


interface KafkaListenerI
{
    public function onKafkaEvent();

    public function setStatus($status);
}