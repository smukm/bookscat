<?php

namespace modules\books\services;

use modules\books\entities\Book;
use modules\books\forms\ReportForm;
use yii\data\ArrayDataProvider;

class ReportService
{
    public function top10(ReportForm $reportForm): ArrayDataProvider
    {
        $data = [];

        $top = Book::find()->top10($reportForm->release_year)->all();

        foreach($top as $item) {
            $data[] = [
                'id' => $item->author_id,
                'author' => $item->author->fullName,
                'books' => $item->cnt
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