<?php

namespace modules\books\events;

use modules\books\contracts\EventDispatcherContract;
use yii\base\InvalidConfigException;
use yii\di\Container;
use yii\di\NotInstantiableException;

class EventDispatcher implements EventDispatcherContract
{
    public function __construct(
        private readonly Container $container,
        private array $listeners
    )
    {
    }

    /**
     * @throws NotInstantiableException
     * @throws InvalidConfigException
     */
    public function dispatchAll(array $events): void
    {
        foreach ($events as $event) {
            $this->dispatch($event);
        }
    }

    /**
     * @throws NotInstantiableException
     * @throws InvalidConfigException
     */
    public function dispatch($event): void
    {
        $eventName = get_class($event);
        if (array_key_exists($eventName, $this->listeners)) {
            foreach ($this->listeners[$eventName] as $listenerClass) {
                $listener = $this->resolveListener($listenerClass);
                $listener($event);
            }
        }
    }

    public function addListener($listener): void
    {
        $this->listeners += $listener;
    }

    /**
     * @throws NotInstantiableException
     * @throws InvalidConfigException
     */
    private function resolveListener($listenerClass): callable
    {
        return [$this->container->get($listenerClass), 'handle'];
    }
}