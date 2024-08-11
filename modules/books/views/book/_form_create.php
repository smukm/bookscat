<?php

use modules\books\entities\Author;
use modules\books\forms\BookForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var BookForm $bookForm
 */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'action' => ['store'],
        'options' => [
            'enctype' => 'multipart/form-data',
        ],
    ]); ?>
    <div class="mb-3">
        <?= $form->field($bookForm, 'title')
            ->textInput(['maxlength' => true]) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($bookForm, 'description')
            ->textarea(['rows' => 6]) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($bookForm, 'release_year')
            ->textInput()
            ->input('number') ?>
    </div>

    <div class="mb-3">
        <?= $form->field($bookForm, 'isbn')
            ->textInput(['maxlength' => true]) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($bookForm, 'photo')
            ->fileInput() ?>
    </div>

    <div class="mb-3">
        <?= $form->field($bookForm, 'author_id')
            ->dropDownList(ArrayHelper::merge(['0' => '---'], Author::getList())) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('books', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
