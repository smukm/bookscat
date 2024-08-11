<?php

namespace modules\books\entities;

use yii\db\ActiveRecord;

/**
 * This is the ActiveQuery class for [[Subscriber]].
 *
 * @see Subscriber
 */
class SubscriberQuery extends \yii\db\ActiveQuery
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
