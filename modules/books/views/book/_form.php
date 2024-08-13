<?php

use kartik\select2\Select2;
use modules\books\entities\Author;
use modules\books\forms\BookForm;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var ActiveForm $form
 * @var BookForm $bookForm
 */
?>
<div class="row mb-3">
    <div class="col-md-6">
        <?= $form->field($bookForm, 'title')
            ->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($bookForm, 'release_year')
            ->textInput()
            ->input('number') ?>
    </div>
</div>

<div class="mb-3">
    <?= $form->field($bookForm, 'description')
        ->textarea(['rows' => 6]) ?>
</div>


<div class="row mb-3">
    <div class="col-md-6">
        <?= $form->field($bookForm, 'photo')
            ->fileInput() ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($bookForm, 'isbn')
            ->textInput(['maxlength' => true]) ?>
    </div>
</div>

<div class="mb-3">
    <?= $form->field($bookForm, 'authors')->widget(Select2::class, [
        'data'          => Author::getList(),
        'theme'         => Select2::THEME_BOOTSTRAP,
        'options'       => [
            'class'       => 'form-control',
            'placeholder' => '-- выберите --',
            'encode'      => false,
            'multiple'    => true
        ],
        'pluginOptions' => [
            'allowClear'    => true,
            'selectOnClose' => true,
        ]
    ])->label(Yii::t('books','Author(s)')); ?>
</div>
