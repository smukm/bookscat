<?php

declare(strict_types=1);

namespace modules\books\entities;

use modules\books\behaviors\CacheInvalidateBehavior;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "authors".
 *
 * @property int $id
 * @property string|null $firstname
 * @property string|null $middlename
 * @property string|null $lastname
 *
 * @property Book[] $books
 */
class Author extends ActiveRecord
{
    public static function create(
        string $firstname,
        string $lastname,
        string $middlename = ''
    ): self
    {
        $model = new self();
        $model->firstname = $firstname;
        $model->lastname = $lastname;
        $model->middlename = $middlename;

        return $model;
    }

    public static function tableName(): string
    {
        return 'authors';
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'firstname' => Yii::t('books', 'Firstname'),
            'middlename' => Yii::t('books', 'Middlename'),
            'lastname' => Yii::t('books', 'Lastname'),
        ];
    }

    public function behaviors(): array
    {
        return [
            'invalidateCache' => [
                'class' => CacheInvalidateBehavior::class,
                'tags' => [
                    [
                        self::tableName(),
                        function ($model) {
                            return $model->id;
                        }
                    ],
                    [
                        self::tableName()
                    ]
                ],
            ]
        ];
    }

    public function getFullName(): string
    {
        return $this->firstname . ' ' . $this->middlename . ' ' . $this->lastname;
    }

    public static function getList(): array
    {
        return ArrayHelper::map(
            self::find()->orderBy(['lastname' => SORT_ASC])->all(),
            'id',
            'fullName'
        );
    }

    public function getBooks(): BookQuery|ActiveQuery
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
            ->viaTable(AuthorBook::tableName(), ['author_id' => 'id']);
    }

    public function getSubscribers(): ActiveQuery
    {
        return $this->hasMany(Subscriber::class, ['author_id' => 'id']);
    }

    public static function find(): AuthorQuery
    {
        return new AuthorQuery(get_called_class());
    }
}
