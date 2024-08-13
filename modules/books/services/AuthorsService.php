<?php

declare(strict_types=1);

namespace modules\books\services;

use DomainException;
use modules\books\entities\Author;
use modules\books\entities\Book;
use modules\books\forms\AuthorForm;
use Throwable;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

class AuthorsService
{
    /**
     * @throws Exception
     */
    public function createAuthor(AuthorForm $form): Author
    {
        $author = Author::create(
            firstname: $form->firstname,
            lastname: $form->lastname,
            middlename: $form->middlename
        );
        if(!$author->save()) {
            throw new DomainException('Unable to create author');
        }

        return $author;
    }

    /**
     * @throws Exception
     * @throws DomainException
     * @throws NotFoundHttpException
     */
    public function editAuthor(AuthorForm $form, int $author_id): Author
    {
        $author = $this->findAuthor($author_id);
        $author->firstname = $form->firstname;
        $author->middlename = $form->middlename;
        $author->lastname = $form->lastname;


        if (!$author->save()) {
            throw new DomainException('Unable to update author');
        }

        return $author;
    }

    /**
     * @throws StaleObjectException
     * @throws NotFoundHttpException
     * @throws Throwable
     */
    public function deleteAuthor(int $author_id): bool
    {
        if($this->isBooksExists($author_id)) {
            throw new DomainException(\Yii::t('books', 'There is books of this author in database'));
        }
        return (bool)$this->findAuthor($author_id)->delete();
    }

    private function isBooksExists(int $author_id): bool
    {
        return Book::find()->joinWith('authors')
            ->where(['author_book.author_id' => $author_id])
            ->exists();
    }

    /**
     * @throws NotFoundHttpException
     */
    public function findAuthor(int $id): Author
    {
        if (($model = Author::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}