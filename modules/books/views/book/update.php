<?php

declare(strict_types=1);

use modules\books\entities\Book;
use modules\books\forms\BookForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var BookForm $bookForm
 * @var Book $book
 */

$this->title = Yii::t('books','Update Book: ') . $book->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('books', 'Books'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $book->title, 'url' => ['view', 'id' => $book->id]];
$this->params['breadcrumbs'][] = Yii::t('books', 'Update');
?>
<div class="book-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form_update', [
        'bookForm' => $bookForm,
        'book' => $book,
    ]) ?>

</div>
