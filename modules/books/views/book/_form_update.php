<?php

use kartik\select2\Select2;
use modules\books\entities\Author;
use modules\books\forms\BookForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var BookForm $bookForm
 * @var modules\books\entities\Book $book
 */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin([
        'method' => 'put',
        'action' => ['update', 'id' => $book->id],
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

    <div class="mb-3 row">
        <div class="col-3">
            <?= $form->field($bookForm, 'photo')
                ->fileInput() ?>
        </div>
        <div class="col-9">
            <?php if(!empty($book->photoUrl)):?>
                <?=Html::img($book->photoUrl, ['width' => '75px'])?>
            <?php endif;?>
        </div>
    </div>

    <div class="mb-3">
        <?= $form->field($bookForm, 'authors')->widget(Select2::class, [
            'data'          => Author::getList(),
            'theme'         => Select2::THEME_BOOTSTRAP,
            'options'       => [
                'class'       => 'form-control',
                'encode'      => false,
                'multiple'    => true
            ],
            'pluginOptions' => [
                'allowClear'    => true,
                'selectOnClose' => true,
            ]
        ])->label(Yii::t('books','Author(s)')); ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('books', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
