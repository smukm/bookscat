<?php

namespace modules\books\entities;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the ActiveQuery class for [[AuthorBook]].
 *
 * @see AuthorBook
 */
class AuthorBookQuery extends ActiveQuery
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
