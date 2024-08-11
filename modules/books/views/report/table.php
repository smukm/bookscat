<?php

use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/**
 * @var yii\web\View $this
 * @var ArrayDataProvider $dataProvider
 */

?>
<div class="report-table">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'author',
                'label' => Yii::t('books', 'Author'),
            ],
            [
                'attribute' => 'books',
                'label' => Yii::t('books', 'Books count'),
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{view}',

                'urlCreator' => function ($action, array $model) {
                    if($action === 'view') {
                        $action ='book/index';
                    }
                    return Url::toRoute([
                        $action,
                        'BookSearch[author_id]' => $model['id']]);
                },
            ],
        ],
    ]); ?>

</div>
