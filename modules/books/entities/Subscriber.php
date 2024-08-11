<?php

namespace modules\books\entities;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "subscribers".
 *
 * @property int $id
 * @property int|null $author_id
 * @property string $phone
 *
 * @property Author $author
 */
class Subscriber extends ActiveRecord
{
    public static function create(int $author_id, string $phone): self
    {
        $subscriber = new self();
        $subscriber->author_id = $author_id;
        $subscriber->phone = $phone;

        return $subscriber;
    }

    public static function tableName(): string
    {
        return 'subscribers';
    }

    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('books', 'ID'),
            'author_id' => Yii::t('books', 'Author ID'),
            'phone' => Yii::t('books', 'Phone'),
        ];
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

    public static function find(): SubscriberQuery
    {
        return new SubscriberQuery(get_called_class());
    }
}
