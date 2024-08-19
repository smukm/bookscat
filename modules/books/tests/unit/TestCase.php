<?php

namespace modules\books\tests\unit;

use modules\books\BooksModule;
use yii\console\Application;

class TestCase extends \Codeception\Test\Unit
{
    protected function setUp(): void
    {
        parent::setUp();
        //$this->mockApp();

    }

    protected function tearDown(): void
    {
        parent::tearDown();
        //$this->destroyApp();
    }


    protected function mockApp()
    {
        new Application([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => dirname(__DIR__) . '/vendor',

            'bootstrap' => ['books'],
            'modules' => [
                'books' => [
                    'class' => BooksModule::class,
                ],
            ],
        ]);
    }

    protected function destroyApp()
    {
        \Yii::$app = null;
    }
}