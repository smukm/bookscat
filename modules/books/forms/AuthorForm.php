<?php

namespace modules\books\forms;

use Yii;
use yii\base\Model;

class AuthorForm extends Model
{
    public string $firstname = '';

    public string $middlename = '';

    public string $lastname = '';

    public function rules()
    {
        return [
            [['firstname', 'middlename', 'lastname'], 'trim'],
            [['firstname', 'lastname'], 'required'],
            [['firstname', 'middlename', 'lastname'], 'string', 'max' => 255],
        ];
    }
    public function attributeLabels()
    {
        return [
            'firstname' => Yii::t('books', 'Firstname'),
            'middlename' => Yii::t('books', 'Middlename'),
            'lastname' => Yii::t('books', 'Lastname'),
        ];
    }
}