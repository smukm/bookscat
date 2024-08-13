<?php

declare(strict_types=1);

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
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
        ],
    ]); ?>

</div>
