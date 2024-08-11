<?php

use modules\books\forms\BookForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var BookForm $bookForm
 */

$this->title = Yii::t('books', 'Create Book');
$this->params['breadcrumbs'][] = ['label' => Yii::t('books', 'Books'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_create', [
        'bookForm' => $bookForm,
    ]) ?>

</div>
