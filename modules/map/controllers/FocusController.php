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

        $id = yii::$app->getRequest()->getQueryParam('id');
        
        $businessDetailsSearch =  new BusinessDetailsSearch();
        $businessDetails = $businessDetailsSearch->findById($id);

        $session = Yii::$app->getSession();
        $origin = $session['origin'];
        $mode = $session['mode'];
        $map = $this->createMap($origin, $businessDetails, $mode);
        
        return $this->render('view', 
            [
                'title' => $businessDetails->name,
                'map' => $map,
                'businessDetails' => $businessDetails,
            ]
        );
    }

    protected function createMap($origin, $destination, $mode) {
        $map = new Map();
        $map->setQueryAndSourceForDirections($origin, $destination, $mode);
        
        return $map;
    }
}