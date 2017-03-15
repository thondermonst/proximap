<?php

namespace app\modules\quizmaker\controllers;

use yii\web\Controller;

class IndexController extends Controller
{
    public function actionIndex() {
        return $this->redirect(['/quizmaker/quiz']);
    }
}