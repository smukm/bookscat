<?php

declare(strict_types=1);

namespace modules\books\entities;

use Yii;
use yii\base\InvalidConfigException;
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
 */
class Book extends ActiveRecord
{

    public static function create(
        string $title,
        int $release_year,
        string $isbn,
        string $description=''
    ): self
    {
        $model = new self();
        $model->title = $title;
        $model->release_year = $release_year;
        $model->isbn = $isbn;
        $model->description = $description;

        return $model;
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_INSERT | self::OP_UPDATE,
        ];
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
        ];
    }


    /**
     * @throws InvalidConfigException
     */
    public function getAuthors(): ActiveQuery
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable(AuthorBook::tableName(), ['book_id' => 'id']);
    }

    public function getAuthorsIds(): array
    {
        return array_map(function ($item) {
            return $item->id;
        }, $this->authors);
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
