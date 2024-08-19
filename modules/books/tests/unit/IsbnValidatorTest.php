<?php

declare(strict_types=1);

namespace modules\books\tests\unit;

use Codeception\Test\Unit;
use modules\books\forms\BookForm;

class IsbnValidatorTest extends Unit
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
