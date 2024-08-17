<?php

declare(strict_types=1);

namespace modules\books\forms;

use InvalidArgumentException;
use modules\books\entities\Author;
use modules\books\entities\Book;
use modules\books\forms\validators\AuthorsValidator;
use modules\books\forms\validators\IsbnValidator;
use Yii;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\web\UploadedFile;

class BookForm extends Model
{
    public string $title = '';

    public string $description = '';

    public int $release_year;

    public string $isbn = '';

    public UploadedFile|string|null $photo = null;


    public string|array $authors = [];

    public bool $isNewRecord = false;

    public int $id;

    public function __construct(int $id = 0, $config = [])
    {
        parent::__construct($config);

        $this->release_year = (int) date('Y');
        $this->id = $id;
    }

    public function rules(): array
    {
        return [
            [['description'], 'string'],
            [['release_year'], 'required'],
            [['release_year'], 'integer', 'min' => 1900, 'max' => (int)date('Y')],
            [['authors'], 'required'],
            [['authors'], AuthorsValidator::class],
            [['title'], 'trim'],
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
            [
                ['photo'],
                'file',
                'extensions' => ['png', 'jpg', 'jpeg', 'gif',],
                'skipOnEmpty' => true,
                'maxSize'=> ini_get_size('upload_max_filesize'),
                'tooBig'=>'File has to be smaller than ' . print_file_size(
                    ini_get_size('upload_max_filesize')
                )
            ],
            [['isbn'], 'trim'],
            [['isbn'], 'string'],
            [['isbn'], 'required'],
            [['isbn'], IsbnValidator::class],
            [
                ['isbn'],
                'unique',
                'targetClass' => Book::class,
                'filter' => function (ActiveQuery $query) {
                    $query->andWhere(['<>', 'id', $this->id]);
                }
            ],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'title' => Yii::t('books','Title'),
            'description' => Yii::t('books','Description'),
            'release_year' => Yii::t('books','Release Year'),
            'isbn' => Yii::t('books','ISBN'),
            'photo' => Yii::t('books','Photo'),
            'authors' => Yii::t('books','Authors'),
        ];
    }

    public function upload(): bool
    {
        $uploadPath = Yii::$app->getModule('books')->getUploadPath();

        if ($this->validate()) {

            $this->photo = UploadedFile::getInstance($this, 'photo');
            if($this->photo instanceof UploadedFile) {
                return $this->photo->saveAs($uploadPath . $this->photo->baseName . '.' . $this->photo->extension);
            }
            return true;
        } else {
            return false;
        }
    }
}