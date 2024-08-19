<?php

declare(strict_types=1);

namespace modules\books\tests\unit;

use modules\books\forms\BookForm;

class AuthorsValidatorTest extends TestCase
{
    public function testEmptyAutors()
    {
        $bookForm = new BookForm();
        $bookForm->authors = [];
        $this->assertFalse($bookForm->validate('authors'));
    }

    public function testInvalidIds()
    {
        $bookForm = new BookForm();
        $bookForm->authors = [1,3];
        $this->assertFalse($bookForm->validate('authors'));
    }

    public function testValidAuthors()
    {
        $bookForm = new BookForm();
        $bookForm->authors = [1,2];
        $this->assertTrue($bookForm->validate('authors'));
    }
}
