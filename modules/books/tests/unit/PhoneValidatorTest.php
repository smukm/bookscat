<?php

declare(strict_types=1);

namespace modules\books\tests\unit;

use Codeception\Test\Unit;
use modules\books\forms\BookForm;
use modules\books\forms\SubscribeForm;

class PhoneValidatorTest extends Unit
{

    public function testInvalidPhone()
    {
        $subscribeForm = new SubscribeForm();
        $subscribeForm->phone = '+7(222)333-44-5';

        $result = $subscribeForm->validate('phone');
        $this->assertFalse($result);
    }

    public function testValidPhone()
    {
        $subscribeForm = new SubscribeForm();
        $subscribeForm->phone = '+7(222)333-44-55';

        $result = $subscribeForm->validate('phone');
        $this->assertTrue($result);
    }
}
