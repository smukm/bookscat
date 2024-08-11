<?php

namespace frontend\tests\unit\books;

use common\fixtures\UserFixture;
use frontend\models\ContactForm;
use modules\books\fixtures\AuthorFixture;
use modules\books\fixtures\BookFixture;
use modules\books\fixtures\SubscriberFixture;
use modules\books\forms\ReportForm;
use modules\books\services\ReportService;
use yii\mail\MessageInterface;

class ReportTest extends \Codeception\Test\Unit
{
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php',
            ],
            'author' => [
                'class' => AuthorFixture::class,
                'dataFile' => '@modules/books/fixtures/data/author.php'
            ],
            'book' => [
                'class' => BookFixture::class,
                'dataFile' => '@modules/books/fixtures/data/book.php'
            ],
            'subscriber' => [
                'class' => SubscriberFixture::class,
                'dataFile' => '@modules/books/fixtures/data/subscriber.php'
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
