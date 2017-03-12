<?php

namespace app\modules\map\controllers;

use app\modules\map\models\Map;
use app\modules\map\models\BusinessDetailsSearch;
use yii\web\Controller;
use Yii;

class FocusController extends Controller
{
    /**
     * Default action
     */
    public function actionIndex() {
        return $this->view();
    }
    
    protected function view() {
        $map = new Map();
        $id = yii::$app->getRequest()->getQueryParam('id');
        
        $businessDetailsSearch =  new BusinessDetailsSearch();
        $businessDetails = $businessDetailsSearch->findById($id);
        $map->search = $businessDetails->address;
        $map->setQueryAndSource();
        
        return $this->render('view', 
            [
                'title' => $businessDetails->name,
                'map' => $map,
                'businessDetails' => $businessDetails,
            ]
        );
    }
}