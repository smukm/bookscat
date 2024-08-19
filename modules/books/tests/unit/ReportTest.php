<?php

namespace modules\books\tests\unit;

use common\fixtures\UserFixture;
use modules\books\forms\ReportForm;
use modules\books\migrations\fixtures\AuthorBookFixture;
use modules\books\migrations\fixtures\AuthorFixture;
use modules\books\migrations\fixtures\BookFixture;
use modules\books\migrations\fixtures\SubscriberFixture;
use modules\books\services\ReportService;

class ReportTest extends TestCase
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

    public function testTop10()
    {
        $reportService = new ReportService();
        $reportForm = new ReportForm();
        $reportForm->release_year = 2024;

        $top = $reportService->top10($reportForm);
        $data = $top->getModels();
        $this->assertEquals(2, $data[0]['books']);
        $this->assertEquals(1, $data[1]['books']);


        $reportForm->release_year = 2022;
        $top = $reportService->top10($reportForm);
        $data = $top->getModels();
        $this->assertEmpty($data);
    }
}
