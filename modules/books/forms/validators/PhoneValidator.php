<?php

declare(strict_types=1);

namespace modules\books\forms\validators;

use Yii;
use yii\validators\Validator;

class PhoneValidator extends Validator
{
    public function validateAttribute($model, $attribute): void
    {
        $phone = $model->$attribute;
        if(strlen($phone) !== 11) {
            $model->addError($attribute, Yii::t('books', 'The phone must have 11 digits'));
        }
    }
}