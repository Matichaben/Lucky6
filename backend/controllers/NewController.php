<?php

namespace backend\controllers;

use yii\web\Controller;

class NewController extends Controller
{
    public function actionIndex()
    {
        return $this->render(view: 'index');
    }
}