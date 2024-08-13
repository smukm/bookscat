<?php

declare(strict_types=1);

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

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form_create', [
        'bookForm' => $bookForm,
    ]) ?>

</div>
