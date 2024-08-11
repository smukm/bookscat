<?php

namespace modules\books\entities;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class AuthorQuery extends ActiveQuery
{
    public function all($db = null): array
    {
        return parent::all($db);
    }

    public function one($db = null): array|ActiveRecord|null
    {
        return parent::one($db);
    }
}
