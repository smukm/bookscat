<?php

declare(strict_types=1);

namespace modules\books\entities;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class BookQuery extends ActiveQuery
{
    public function all($db = null): array
    {
        return parent::all($db);
    }

    public function one($db = null): array|ActiveRecord|null|Book
    {
        return parent::one($db);
    }
}
