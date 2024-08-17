<?php

declare(strict_types=1);

namespace modules\books\forms\validators;

use Yii;
use yii\validators\Validator;

class IsbnValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $isValid = (new Isbn())($model->$attribute);

        if(!$isValid) {
            $model->addError($attribute, Yii::t('books', 'Not valid ISBN'));
        }
    }
}