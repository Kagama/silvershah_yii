<?php

namespace frontend\modules\pages\controllers;

use common\modules\pages\models\Pages;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $models = Pages::find()->all();
        return $this->render('index',[
            'models' => $models
        ]);
    }

    public function actionShow($page)
    {
        $model = Pages::find()->where('alt_title = :alt', [':alt' => $page])->one();
        if($model == null)
            throw new NotFoundHttpException('Страница не найдена.');

        return $this->render('show', ['model' => $model]);
    }
}
