<?php

use modules\books\forms\ReportForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var ReportForm $reportForm
 */
?>
<div class="report-form mb-4">
    <?php

    $form = ActiveForm::begin([
        'method' => 'post',
        'action' => ['top'],
        'options' => [
            'class' => ['row row-cols-auto g-3 align-items-center']
        ],
    ]); ?>

    <?= $form->field($reportForm, 'release_year')
        ->textInput(['maxlength' => true])
        ->input('number', ['placeholder' => Yii::t('books', 'Enter Release Year')])
        ->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('books', 'Report'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>