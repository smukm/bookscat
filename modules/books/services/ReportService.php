<?php

declare(strict_types=1);

namespace modules\books\services;

use modules\books\entities\Book;
use modules\books\forms\ReportForm;
use Yii;
use yii\caching\TagDependency;
use yii\data\ArrayDataProvider;
use yii\db\Query;

class ReportService
{
    public function top10(ReportForm $reportForm): ArrayDataProvider
    {
        $data = [];

        $top = (new Query())->select([
            'authors.id',
            "CONCAT_WS(' ', authors.firstname, authors.middlename, authors.lastname) as fullname",
            'COUNT(books.id) as cnt'
        ])->cache(Yii::$app->params['cacheDuration'], new TagDependency(['tags' => Book::tableName()]))
            ->from('books')
            ->innerJoin('author_book', 'author_book.book_id=books.id')
            ->innerJoin('authors', 'author_book.author_id=authors.id')
            ->groupBy('authors.id')
            ->orderBy(['cnt' => SORT_DESC])
            ->where(['books.release_year' => $reportForm->release_year])
            ->limit(10)
        ->all();

        foreach($top as $item) {
            $data[] = [
                'id' => $item['id'],
                'author' => $item['fullname'],
                'books' => $item['cnt'],
            ];
        }

        return new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }
}