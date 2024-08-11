<?php

namespace modules\books\entities;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property int|null $release_year
 * @property string|null $isbn
 * @property string|null $photo
 * @property int|null $author_id
 *
 * @property Author $author
 */
class Book extends ActiveRecord
{

    public int $cnt;

    public static function create(
        string $title,
        int $release_year,
        string $isbn,
        int $author_id,
        string $description=''
    ): self
    {
        $model = new self();
        $model->title = $title;
        $model->release_year = $release_year;
        $model->isbn = $isbn;
        $model->author_id = $author_id;
        $model->description = $description;

        return $model;
    }

    public static function tableName(): string
    {
        return 'books';
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => Yii::t('books','Title'),
            'description' => Yii::t('books','Description'),
            'release_year' => Yii::t('books','Release Year'),
            'isbn' => Yii::t('books','ISBN'),
            'photo' => Yii::t('books','Photo'),
            'author_id' => Yii::t('books','Author ID'),
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return ActiveQuery|AuthorQuery
     */
    public function getAuthor(): AuthorQuery|ActiveQuery
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

    public function getPhotoUrl(): string
    {
        if(!empty($this->photo)) {
            $uploadPath = Yii::$app->getModule('books')->getUploadPath();
            if(is_file($uploadPath . $this->photo)) {
                return Url::to(Url::base(true) . '/'. $uploadPath . $this->photo);
            }
        }

        return '';
    }

    public static function find(): BookQuery
    {
        return new BookQuery(get_called_class());
    }
}
