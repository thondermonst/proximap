<?php

namespace app\modules\twitter\controllers;

use yii\web\Controller;
use app\modules\twitter\models\Codebird;
use Yii;

class IndexController extends Controller
{
    public function actionIndex() {
        Codebird::setConsumerKey(Yii::$app->params['twitterConsumerKey'], Yii::$app->params['twitterConsumerSecret']);
        $cb = Codebird::getInstance();
        $cb->setToken(Yii::$app->params['twitterAccessToken'], Yii::$app->params['twitterAccessTokenSecret']);
        
        //Need SSL first
        
        return $this->render('index');
    }
}