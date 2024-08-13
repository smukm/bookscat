<?php

declare(strict_types=1);

namespace modules\books\events;

use Yii;

abstract class Event
{
    public function fire(): void
    {
        $dispatcher = Yii::$container->get(EventDispatcher::class);
        $dispatcher->dispatch($this);
    }
}