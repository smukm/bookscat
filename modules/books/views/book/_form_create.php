<?php

declare(strict_types=1);

use kartik\select2\Select2;
use modules\books\entities\Author;
use modules\books\forms\BookForm;
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

    <?=$this->render('_form', [
            'form' => $form,
            'bookForm' => $bookForm
    ])?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('books', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
