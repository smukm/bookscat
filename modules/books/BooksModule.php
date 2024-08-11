<?php

namespace modules\books;

use modules\books\contracts\SubscribeNotifyContract;
use modules\books\events\BookAddedEvent;
use modules\books\events\EventDispatcher;
use modules\books\listeners\BookAddedListener;
use modules\books\notifications\SmsPilotNotifier;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\Module;
use yii\di\Container;

class BooksModule extends Module implements BootstrapInterface
{
    private string $uploadPath = 'uploads';

    public function getUploadPath(): string
    {
        return str_replace('//', '/',$this->uploadPath . '/');
    }
    public function bootstrap($app): void
    {
        $module = $this->id;

        // Add module I18N category.
        if (!isset($app->i18n->translations[$module]) && !isset($app->i18n->translations['modules/*'])) {
            $app->i18n->translations[$module] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@modules/' . $module . '/messages',
                'forceTranslation' => true,
                'fileMap' => [
                    'modules/' . $module => $module . '.php',
                ]
            ];
        }

        $container = Yii::$container;

        $container->setSingleton(SubscribeNotifyContract::class, SmsPilotNotifier::class);

        $container->setSingleton(EventDispatcher::class, function (Container $container) {
            return new EventDispatcher($container, [
               BookAddedEvent::class => [
                   BookAddedListener::class
               ]
            ]);
        });
    }
}