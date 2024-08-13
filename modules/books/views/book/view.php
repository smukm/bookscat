<?php

declare(strict_types=1);

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var modules\books\entities\Book $book
 */

$this->title = $book->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('books','Books'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if(!Yii::$app->user->isGuest):?>
            <?= Html::a(Yii::t('books','Edit'), ['edit', 'id' => $book->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('books','Delete'), ['delete', 'id' => $book->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif;?>
    </p>

    <?php
    //dd($book->authors);

    ?>
    <?= DetailView::widget([
        'model' => $book,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            'release_year',
            'isbn',
            [
                'attribute' => 'photo',
                'format' => 'raw',
                'value' => function () use ($book) {
                    return (!empty($book->photoUrl))
                        ? Html::img(
                            $book->photoUrl,
                            ['width' => '250px'])
                        : '';
                }
            ],
            [
                'attribute' => 'author',
                'label' => Yii::t('books', 'Author'),
                'value' => function () use ($book) {
                    $ret = [];
                    foreach($book->authors as $author) {
                        $ret[] = $author->fullName;
                    }
                    return implode(', ', $ret);
                    //$book->author->fullName
                }
            ],
        ],
    ]) ?>

</div>
