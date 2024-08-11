<?php

use modules\books\forms\AuthorForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var AuthorForm $authorForm
 */

$this->title = Yii::t('books','Create Author');
$this->params['breadcrumbs'][] = ['label' => Yii::t('books','Authors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_create', [
        'authorForm' => $authorForm,
    ]) ?>

</div>
