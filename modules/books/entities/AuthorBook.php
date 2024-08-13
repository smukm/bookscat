<?php

declare(strict_types=1);

namespace modules\books\entities;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "author_book".
 *
 * @property int $id
 * @property int $author_id
 * @property int $book_id
 *
 */
class AuthorBook extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'author_book';
    }

    public function rules(): array
    {
        return [
            [['author_id', 'book_id'], 'required'],
            [['author_id', 'book_id'], 'integer'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['author_id' => 'id']],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('books', 'ID'),
            'author_id' => Yii::t('books', 'Author ID'),
            'book_id' => Yii::t('books', 'Book ID'),
        ];
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

    public function getBook(): ActiveQuery
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }

    public static function find(): AuthorBookQuery
    {
        return new AuthorBookQuery(get_called_class());
    }
}
