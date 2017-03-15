<?php

namespace app\modules\quizmaker\controllers;

use yii\web\Controller;

class QuizController extends Controller
{
    public function actionIndex() {
        return $this->render('overview');
    }
}