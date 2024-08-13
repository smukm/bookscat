<?php

declare(strict_types=1);

use kartik\select2\Select2;
use modules\books\entities\Author;
use modules\books\forms\BookForm;
use yii\helpers\Html;
use yii\helpers\Url;
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
            'id' => 'book-form',
            'enctype' => 'multipart/form-data',
            'data-edit-url' => Url::to(['edit', 'id' => $book->id]),
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
<?php echo $this->render('_modal_create_author');?>