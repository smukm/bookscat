<?php

declare(strict_types=1);

namespace modules\books\forms;

use yii\base\Model;

class ReportForm extends Model
{

    public int $release_year;

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->release_year = (int) date('Y');
    }

    public function rules(): array
    {
        return [
            [['release_year'], 'required'],
            [['release_year'], 'integer', 'min' => 1900, 'max' => (int)date('Y')],
        ];
    }


    public function attributeLabels(): array
    {
        return [
            'release_year' => \Yii::t('books','Release Year'),
        ];
    }
}