<?php

use modules\books\entities\Author;
use modules\books\forms\AuthorForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var AuthorForm $authorForm
 * @var Author $author
 */

$this->title = Yii::t('books','Update Author: ') . $author->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('books','Authors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $author->id, 'url' => ['view', 'id' => $author->id]];
$this->params['breadcrumbs'][] = Yii::t('books','Update');
?>
<div class="author-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_update', [
        'author' => $author,
        'authorForm' => $authorForm,
    ]) ?>

</div>
