<?php

declare(strict_types=1);

use modules\books\forms\AuthorForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var AuthorForm $authorForm
 * @var ActiveForm $form
 */
?>

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