<?php

namespace modules\books\listeners;

use modules\books\contracts\SubscribeNotifyContract;

use modules\books\events\BookAddedEvent;
use yii\helpers\ArrayHelper;

class BookAddedListener
{
    private SubscribeNotifyContract $notifier;

    public function __construct(
        SubscribeNotifyContract $notifier
    )
    {
        $this->notifier = $notifier;
    }

    public function handle(BookAddedEvent $event): void
    {
        $authors = $event->book->authors;
        $all_subscribers = [];
        foreach($authors as $author) {
            $subscribers = $author
                ->getSubscribers()
                ->select('phone')
                ->column();
            if($subscribers) {
                $all_subscribers = ArrayHelper::merge($all_subscribers, $subscribers);
            }
        }

        if($all_subscribers) {
            $this->notifier->send(array_unique($all_subscribers), $event->book);
        }
    }
}