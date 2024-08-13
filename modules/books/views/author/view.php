<?php

declare(strict_types=1);

use modules\books\entities\Author;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var Author $author
 */

$this->title = $author->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('books', 'Authors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="author-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if(!Yii::$app->user->isGuest):?>
    <p>
        <?= Html::a(Yii::t('books', 'Edit'), ['edit', 'id' => $author->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('books', 'Delete'), ['delete', 'id' => $author->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php endif;?>

    <?= DetailView::widget([
        'model' => $author,
        'attributes' => [
            'id',
            'firstname',
            'middlename',
            'lastname',
        ],
    ]) ?>

</div>
