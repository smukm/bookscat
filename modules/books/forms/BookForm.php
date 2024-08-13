<?php

declare(strict_types=1);

namespace modules\books\forms;

use InvalidArgumentException;
use modules\books\entities\Author;
use modules\books\entities\Book;
use Yii;
use yii\base\Model;
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

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->release_year = (int) date('Y');
    }

    public function rules(): array
    {
        return [
            [['description'], 'string'],
            [['release_year'], 'required'],
            [['release_year'], 'integer'],
            [['authors'], 'required'],
            [['authors'], 'validateAuthors'],
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
            [['isbn'], 'validateIsbn'],
            [
                ['isbn'],
                'unique',
                'targetClass' => Book::class,
                'when' => function ($model) {
                    return $model->isNewRecord;
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

    public function validateAuthors($attribute): void
    {
        $authors = $this->$attribute;
        if(!is_array($authors)) {
            $this->addError($attribute, Yii::t('books', 'The author not chosen'));
        }

        foreach($authors as $author_id) {
            $author = Author::findOne($author_id);
            if(!$author) {
                $this->addError($attribute, Yii::t('books', 'The author not chosen'));
            }
        }
    }

    public function validateIsbn($attribute): void
    {
        $isbn = $this->$attribute;
        $isbn = preg_replace('#\D#', '', $isbn);

        try {
            $isValid = false;

            if(strlen($isbn) === 10) {
                $isValid = $this->check10Isbn($isbn);
            } elseif((strlen($isbn) === 13)) {
                $isValid = $this->check13Isbn($isbn);
            }

            if (!$isValid) {
                throw new InvalidArgumentException(Yii::t('books', 'Not valid ISBN'));
            }

        } catch (InvalidArgumentException $ex) {
            $this->addError($attribute, $ex->getMessage());
        }
    }

    private function check10Isbn(string $isbn): bool
    {
        $digits = str_split($isbn);

        $sum = 0;

        foreach ($digits as $index => $digit) {

            $sum += ($index + 1) * (int)$digit;
        }

        return ($sum % 11) === 0;
    }

    private function check13Isbn(string $isbn): bool
    {
        $digits = str_split($isbn);

        $check = 0;
        for ($i = 0; $i < 13; $i += 2) {
            $check += (int)$digits[$i];
        }

        for ($i = 1; $i < 12; $i += 2) {
            $check += 3 * $digits[$i];
        }

        return ($check % 10) === 0;
    }
}