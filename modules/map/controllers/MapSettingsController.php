<?php

namespace app\modules\map\controllers;

use yii\base\Controller;

class MapSettingsController extends Controller
{

    public function actionIndex() {
        return $this->view();
    }

    public function actionChange() {

    }


    public function view() {
        return $this->render('view',
            [
                'title' => 'Map Settings',
            ]
        );
    }
}