<?php

declare(strict_types=1);

use modules\books\entities\Author;
use modules\books\forms\AuthorForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var AuthorForm $authorForm
 * @var Author $author
 */
?>

<div class="author-form">

    <?php $form = ActiveForm::begin([
        'method' => 'put',
        'action' => ['update', 'id' => $author->id],
        'options' => [
            'id' => 'author-update-form',
            'data-pjax' => true
        ]
    ]); ?>

    <?=$this->render('_form', [
        'form' => $form,
        'authorForm' => $authorForm
    ])?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('books', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
