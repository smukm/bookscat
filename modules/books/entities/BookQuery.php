<?php

namespace modules\books\entities;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class BookQuery extends \yii\db\ActiveQuery
{
    public function all($db = null): array
    {
        return parent::all($db);
    }

    public function one($db = null): array|ActiveRecord|null
    {
        return parent::one($db);
    }

    public function top10(int $year): ActiveQuery
    {
        return $this->select(['author_id', 'COUNT(*) as cnt'])
            ->with('author')
            ->groupBy('author_id')
            ->orderBy(['cnt' => SORT_DESC])
            ->where(['release_year' => $year])
            ->limit(10);
    }
}
