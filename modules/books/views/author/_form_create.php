<?php

declare(strict_types=1);

use modules\books\forms\AuthorForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var AuthorForm $authorForm
 */
?>

<div class="author-form">
    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'action' => ['store'],
        'options' => [
            'id' => 'author-create-form',
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