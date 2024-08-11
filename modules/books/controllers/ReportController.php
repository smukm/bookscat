<?php

namespace modules\books\controllers;

use modules\books\forms\ReportForm;
use modules\books\services\ReportService;
use Yii;
use yii\web\Controller;

class ReportController extends Controller
{
    public function actionTop(): string
    {
        $reportService = new ReportService();
        $reportForm = new ReportForm();
        if(Yii::$app->request->isPost) {
            $reportForm->load(Yii::$app->request->post());
        }

        $dataProvider = $reportService->top10($reportForm);

        return $this->render('top', [
            'reportForm' => $reportForm,
            'dataProvider' => $dataProvider,
        ]);
    }
}