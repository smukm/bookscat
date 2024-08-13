<?php

declare(strict_types=1);

namespace modules\books\forms;

use modules\books\entities\Author;
use Yii;
use yii\base\Model;

class SubscribeForm extends Model
{
    public string $phone = '';

    public string $author_ids = '';

    public string $authors_names = '';

    public int $subscribe = 1;

    public function rules(): array
    {
        return [
            [['phone'], 'trim'],
            [['phone'], 'required'],
            [['phone'], 'string'],
            [['phone'], 'phoneValidator'],
            [['subscribe'], 'integer'],
            [['authors_names', 'author_ids'], 'string'],
            [['author_ids'], 'required'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'phone' => Yii::t('books', 'Phone number'),
            'subscribe' => Yii::t('books','Subscribe/Unsubscribe'),
        ];
    }

    public function beforeValidate(): bool
    {
        $this->phone = preg_replace('#\D#', '', $this->phone);

        return parent::beforeValidate();
    }

    public function phoneValidator($attrib): void
    {
        $phone = $this->$attrib;
        if(strlen($phone) !== 11) {
            $this->addError($attrib, Yii::t('books', 'The phone must have 11 digits'));
        }
    }

    public function setAuthorsNames(): void
    {
        $ret = [];
        $authors = Author::find()->where(['in', 'id', explode(';', $this->author_ids)])
            ->all();
        foreach ($authors as $author) {
            $ret[] = $author->fullName;
        }

        $this->authors_names = implode(', ', $ret);
    }
}