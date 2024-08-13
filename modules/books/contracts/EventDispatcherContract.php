<?php

declare(strict_types=1);

namespace modules\books\contracts;

interface EventDispatcherContract
{
    public function dispatchAll(array $events): void;
    public function dispatch($event): void;
}