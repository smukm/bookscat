<?php

use modules\books\entities\Author;
use modules\books\entities\AuthorSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/**
 * @var yii\web\View $this
 * @var AuthorSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('books', 'Authors');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if(!Yii::$app->user->isGuest):?>
        <p>
            <?= Html::a(Yii::t('books', 'Create Author'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif;?>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'firstname',
            'middlename',
            'lastname',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Author $model, $key, $index, $column) {
                    if($action === 'update') {
                        $action = 'edit';
                    }
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                'visibleButtons' => [
                    'update' => !Yii::$app->user->isGuest,
                    'delete' => !Yii::$app->user->isGuest,
                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
