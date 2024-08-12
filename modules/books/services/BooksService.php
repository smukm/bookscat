<?php

declare(strict_types = 1);

namespace modules\books\services;


use DomainException;
use modules\books\entities\AuthorBook;
use modules\books\entities\Book;
use modules\books\events\BookAddedEvent;
use modules\books\forms\BookForm;
use Throwable;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class BooksService
{
    /**
     * @throws Exception
     */
    public function createBook(BookForm $form): Book
    {
        $book = Book::create(
            title: $form->title,
            release_year: $form->release_year,
            isbn: $form->isbn,
            //author_id: $form->author_id,
            description: $form->description
        );

        if($form->photo instanceof UploadedFile) {
            $book->photo = $form->photo->name;
        }

        if(!$book->save()) {
            throw new DomainException('Unable to create book');
        }

        $this->setAuthors($book, $form->authors);

        (new BookAddedEvent($book))->fire();

        return $book;
    }

    /**
     * @throws Exception
     * @throws DomainException
     * @throws NotFoundHttpException
     */
    public function editBook(BookForm $form, int $book_id): Book
    {
        $book = $this->findBook($book_id);
        $book->title = $form->title;
        $book->release_year = $form->release_year;
        $book->isbn = $form->isbn;
        $book->description = $form->description;
        if($form->photo instanceof UploadedFile) {
            // delete old photo
            $this->removePhoto($book->photo);
            $book->photo = $form->photo->name;
        }

        if (!$book->save()) {
            throw new DomainException('Unable to update book');
        }

        $this->setAuthors($book, $form->authors);

        return $book;
    }


    private function setAuthors(Book $book, array $authors): void
    {

        $transaction = Yii::$app->db->beginTransaction();

        try {


            $old = AuthorBook::find()->where(['book_id' => $book->id])->all();
            if ($old) {
                foreach ($old as $item) {
                    $item->delete();
                }
            }

            foreach ($authors as $author_id) {
                $ab = new AuthorBook();
                $ab->book_id = $book->id;
                $ab->author_id = $author_id;
                $ab->save();
            }

            $transaction->commit();

        } catch (Throwable $ex) {
            $transaction->rollBack();
            dd($ex->getTraceAsString());
        }


    }

    /**
     * @throws Throwable
     * @throws StaleObjectException
     * @throws NotFoundHttpException
     */
    public function deleteBook(int $book_id): bool
    {
        $book = $this->findBook($book_id);

        $this->removePhoto($book->photo);

        return (bool) $book->delete();
    }

    private function removePhoto(string|null $photo): void
    {
        $uploadPath = Yii::$app->getModule('books')->getUploadPath();

        if(is_file($uploadPath . $photo)) {
            unlink($uploadPath . $photo);
        }
    }

    /**
     * @throws NotFoundHttpException
     */
    public function findBook(int $id): array|ActiveRecord|null|Book
    {
        if (($model = Book::find()
                ->with('authors')
                ->where(['id' => $id])
                ->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}