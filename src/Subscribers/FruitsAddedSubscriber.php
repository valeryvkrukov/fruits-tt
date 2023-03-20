<?php

namespace App\Subscribers;

use App\Event\FruitsAddedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FruitsAddedSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            FruitsAddedEvent::NAME => 'onFruitsAddedEvent',
        ];
    }

    public function onFruitsAddedEvent(FruitsAddedEvent $event): void
    {
        $event->sendEmail();
    }
}