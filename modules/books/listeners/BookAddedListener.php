<?php

namespace modules\books\listeners;

use modules\books\contracts\SubscribeNotifyContract;

use modules\books\events\BookAddedEvent;

class BookAddedListener
{
    private SubscribeNotifyContract $notifier;

    public function __construct(
        SubscribeNotifyContract $notifier
    )
    {
        $this->notifier = $notifier;
    }

    public function handle(BookAddedEvent $event)
    {
        $subscribers = $event->book->author
            ->getSubscribers()
            ->select('phone')
            ->column();

        if($subscribers) {
            $this->notifier->send($subscribers, $event->book);
        }
    }
}