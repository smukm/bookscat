<?php

use modules\books\entities\Book;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
/**
 * @var yii\web\View $this
 * @var modules\books\entities\BookSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('books', 'Books');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if(!Yii::$app->user->isGuest):?>
        <p>
            <?= Html::a(Yii::t('books','Create Book'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif;?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'photo',
                'value' => static function ($data) {
                    return (!empty($data->photoUrl))
                        ? Html::img(
                            $data->photoUrl,
                            ['width' => '75px'])
                        : '';
                },
                'format' => 'raw',
            ],
            'title',
            'description:ntext',
            'release_year',
            'isbn',
            [
                'attribute' => 'author_name',
                'value' => static function ($data) {
                    return $data->author->fullName;
                }
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete} {subscribe} {unsubscribe}',
                'buttons' => [
                    'subscribe' => function ($url) {
                        return Html::a(
                            '<svg style="display:inline-block;font-size:inherit;height:1em;overflow:visible;vertical-align:-.125em;width:.875em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg>',
                            $url,
                            [
                                'title' => Yii::t('books','To subscribe'),
                                'class' => 'modalButton'
                            ]
                        );
                    },
                ],
                'urlCreator' => function ($action, Book $model) {
                    if($action === 'update') {
                        $action = 'edit';
                    }
                    if($action === 'subscribe') {
                        return Url::toRoute(['show-modal', 'id' => $model->id]);
                    }
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'visibleButtons' => [
                    'update' => !Yii::$app->user->isGuest,
                    'delete' => !Yii::$app->user->isGuest,
                    'subscribe' => Yii::$app->user->isGuest,
                ]
            ],
        ],
    ]); ?>

</div>

<?php echo $this->render('_modal');?>