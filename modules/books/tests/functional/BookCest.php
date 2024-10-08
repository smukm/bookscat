<?php

namespace modules\books\tests\functional;

use common\fixtures\UserFixture;
use frontend\tests\FunctionalTester;
use modules\books\tests\fixtures\AuthorBookFixture;
use modules\books\tests\fixtures\AuthorFixture;
use modules\books\tests\fixtures\BookFixture;
use modules\books\tests\fixtures\SubscriberFixture;

class BookCest
{
    public function _fixtures()
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

    public function checkAccess(FunctionalTester $I)
    {
        $I->wantTo('Check access for user and guests');

        $I->amOnRoute('/books/book/index');
        $I->seeElement('a', ['title' => 'Подписаться']);
        $I->dontSeeElement('a', ['title' => 'Редактировать']);
        $I->dontSeeElement('a', ['title' => 'Удалить']);

        $I->amLoggedInAs(1);
        $I->amOnRoute('/books/book/index');
        $I->seeElement('a', ['title' => 'Редактировать']);
        $I->seeElement('a', ['title' => 'Удалить']);
        $I->dontSeeElement('a', ['title' => 'Подписаться']);
    }

    public function checkBooks(FunctionalTester $I)
    {
        $I->wantTo('Check all books showed');

        $I->amOnRoute('/books/book/index');
        $I->see('Война и мир');
        $I->see('Казаки');
        $I->see('Норвежский лес');
    }

    public function checkAuthors(FunctionalTester $I)
    {
        $I->wantTo('Check all authors showed');

        $I->amOnRoute('/books/author/index');
        $I->see('Толстой');
        $I->see('Мураками');
    }
}