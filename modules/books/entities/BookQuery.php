<?php

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

    public function top10(int $year): ActiveQuery
    {
        return $this->select([
            'authors.id',
            "CONCAT_WS(' ', authors.firstname, authors.middlename, authors.lastname) as fullname",
            'COUNT(books.id) as cnt'
        ])
            ->joinWith('authors')
            ->groupBy('authors.id')
            ->orderBy(['cnt' => SORT_DESC])
            ->where(['books.release_year' => $year])
            ->limit(10);
    }
}
