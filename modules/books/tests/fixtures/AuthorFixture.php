<?php

declare(strict_types=1);

namespace modules\books\tests\fixtures;

use yii\test\ActiveFixture;

class AuthorFixture extends ActiveFixture
{
    public $modelClass = 'modules\books\entities\Author';
}