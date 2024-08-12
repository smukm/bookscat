<?php

declare(strict_types=1);

namespace modules\books\services;

use modules\books\entities\Book;
use modules\books\forms\ReportForm;
use yii\data\ArrayDataProvider;

class ReportService
{
    public function top10(ReportForm $reportForm): ArrayDataProvider
    {
        $data = [];

        $top = Book::find()
            ->top10($reportForm->release_year)
            ->asArray()
            ->all();

        foreach($top as $item) {
            $data[] = [
                'id' => $item['id'],
                'author' => $item['fullname'],
                'books' => $item['cnt']
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