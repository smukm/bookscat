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
    <?php Pjax::begin(['id' => 'author-create']) ?>

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
    <?php Pjax::end() ?>
</div>
<?php
$js = <<< JS

    $("#author-create").on("pjax:end", function() {

        if ($('#author-create-form').find('.has-error').length) {
            return;
        }
        
        var url = $('#book-form').data('edit-url');
        
        $('#created_auhor_fio').html(
            'Создан автор: ' +
            $('#authorform-firstname').val() + ' ' +
            $('#authorform-middlename').val() + ' ' +
            $('#authorform-lastname').val() + ' '
            
        );
       
        // reload select with created author
        $.pjax.reload({
            container:"#author-select-container",
            url: url, 
        });
        
        // close the modal
        var myModalEl = document.getElementById('modal');
        var modal = bootstrap.Modal.getInstance(myModalEl)
        modal.hide();
    });
JS;
$this->registerJs($js);