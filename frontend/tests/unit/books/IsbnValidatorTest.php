<?php

namespace frontend\tests\unit\books;

use common\fixtures\UserFixture;
use modules\books\fixtures\AuthorFixture;
use modules\books\fixtures\BookFixture;
use modules\books\fixtures\SubscriberFixture;
use modules\books\forms\BookForm;
use modules\books\forms\ReportForm;
use modules\books\services\ReportService;

class IsbnValidatorTest extends \Codeception\Test\Unit
{
    public function testValidIsbn13()
    {
        $bookForm = new BookForm();
        $bookForm->isbn = '978-1-56619-909-4';

        $result = $bookForm->validate('isbn');
        $this->assertTrue($result);
    }

    public function testInvalidIsbn13()
    {
        $bookForm = new BookForm();
        $bookForm->isbn = '1234567891234';

        $result = $bookForm->validate('isbn');
        $this->assertFalse($result);
    }

    public function testValidIsbn10()
    {
        $bookForm = new BookForm();
        $bookForm->isbn = '1112223339';

        $result = $bookForm->validate('isbn');
        $this->assertTrue($result);
    }

    public function testInvalidIsbn10()
    {
        $bookForm = new BookForm();
        $bookForm->isbn = '1234512345';

        $result = $bookForm->validate('isbn');
        $this->assertFalse($result);
    }

}
