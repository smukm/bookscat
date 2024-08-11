<?php

use modules\books\forms\SubscribeForm;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;
use yii\widgets\Pjax;

/**
 * @var SubscribeForm $subscribeForm
 */
?>

<?php Pjax::begin(['id' => 'subscribe']) ?>
<?php $form = ActiveForm::begin([
    'enableClientValidation' => true,
    'method' => 'post',
    'action' => ['subscribe'],
    'options' => [
        'id' => 'subscribe-form',
        'data-pjax' => true
    ]
]); ?>
<div class="modal-body">
    <h5 id="author-name">Автор: <?=$subscribeForm->authors_names?></h5>

    <?php echo $form->field($subscribeForm, 'author_ids')
        ->hiddenInput()->label(false); ?>

    <?php echo $form->field($subscribeForm, 'phone')
        ->widget(MaskedInput::class, [
            'mask' => '+7 (999) 999 99 99',
        ])->textInput(); ?>
    <?php echo $form->field($subscribeForm, 'subscribe')
        ->dropDownList([
            '1' => Yii::t('books','To subscribe'),
            '0' => Yii::t('books','To unsubscribe')
        ]); ?>
</div>
<div class="modal-footer">
    <?= Html::submitButton(Yii::t('books', 'Send'), ['class' => 'btn btn-success']) ?>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=Yii::t('books','Close')?></button>
</div>
<?php ActiveForm::end(); ?>
<?php Pjax::end() ?>
