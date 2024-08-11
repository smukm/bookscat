<?php

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
        'action' => ['update', 'id' => $author->id]
    ]); ?>


    <div class="mb-3">
        <?= $form->field($authorForm, 'firstname')
            ->textInput(['maxlength' => true]) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($authorForm, 'middlename')
            ->textInput(['maxlength' => true]) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($authorForm, 'lastname')
            ->textInput(['maxlength' => true]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('books', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
