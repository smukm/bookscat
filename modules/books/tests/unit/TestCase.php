<?php

declare(strict_types=1);

namespace modules\books\tests\unit;

use Codeception\Test\Unit;
use common\fixtures\UserFixture;
use modules\books\tests\fixtures\AuthorBookFixture;
use modules\books\tests\fixtures\AuthorFixture;
use modules\books\tests\fixtures\BookFixture;
use modules\books\tests\fixtures\SubscriberFixture;

class TestCase extends Unit
{

    public function _fixtures(): array
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => '@frontend/tests/_data/login_data.php',
            ],
            'author' => [
                'class' => AuthorFixture::class,
                'dataFile' => '@modules/books/tests/fixtures/data/author.php'
            ],
            'book' => [
                'class' => BookFixture::class,
                'dataFile' => '@modules/books/tests/fixtures/data/book.php'
            ],
            'author_book' => [
                'class' => AuthorBookFixture::class,
                'dataFile' => '@modules/books/tests/fixtures/data/author_book.php'
            ],
            'subscriber' => [
                'class' => SubscriberFixture::class,
                'dataFile' => '@modules/books/tests/fixtures/data/subscriber.php'
            ],
        ];
    }
}