<?php

namespace modules\books\forms;

use modules\books\entities\Author;
use yii\base\Model;

class SubscribeForm extends Model
{
    public string $phone = '';

    public int $author_id = 0;

    public string $author_name = '';

    public int $subscribe = 1;

    public function rules(): array
    {
        return [
            [['phone'], 'trim'],
            [['phone'], 'required'],
            [['phone'], 'string'],
            [['phone'], 'phoneValidator'],
            [['subscribe'], 'integer'],
            [['author_name'], 'string'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'phone' => \Yii::t('books', 'Phone number'),
            'subscribe' => \Yii::t('books','Subscribe/Unsubscribe'),
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
            $this->addError($attrib, \Yii::t('books', 'The phone must have 11 digits'));
        }
    }
}