<?php

declare(strict_types=1);

use modules\books\forms\AuthorForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var AuthorForm $authorForm
 * @var bool $with_pjax
 */

$this->title = Yii::t('books','Create Author');
$this->params['breadcrumbs'][] = ['label' => Yii::t('books','Authors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="author-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?php if($with_pjax):?>
        <?= $this->render('_form_create_pjax', [
            'authorForm' => $authorForm,
        ]) ?>
    <?php else:?>
        <?= $this->render('_form_create', [
            'authorForm' => $authorForm,
        ]) ?>
    <?php endif;?>

</div>
