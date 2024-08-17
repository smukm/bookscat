<?php

declare(strict_types=1);

namespace modules\books\forms\validators;

use modules\books\entities\Author;
use Yii;
use yii\validators\Validator;

class AuthorsValidator extends Validator
{
    public function validateAttribute($model, $attribute): void
    {
        $authors = $model->$attribute;
        if(!is_array($authors)) {
            $model->addError($attribute, Yii::t('books', 'The author not chosen'));
        }

        foreach($authors as $author_id) {
            $author = Author::findOne($author_id);
            if(!$author) {
                $model->addError($attribute, Yii::t('books', 'The author not chosen'));
            }
        }
    }
}