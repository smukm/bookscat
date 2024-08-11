<?php

use modules\books\forms\ReportForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;

/**
 * @var ReportForm $reportForm
 * @var ArrayDataProvider $dataProvider
 */

$this->title = Yii::t('books', 'Top 10');
$this->params['breadcrumbs'][] = ['label' => Yii::t('books', 'Books'), 'url' => ['book/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="report-top10">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'reportForm' => $reportForm,
    ]) ?>

    <?= $this->render('table', [
        'dataProvider' => $dataProvider,
    ]) ?>
</div>