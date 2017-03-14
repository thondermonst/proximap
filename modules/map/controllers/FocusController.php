<?php

namespace app\modules\map\controllers;

use app\modules\map\models\Map;
use app\modules\map\models\BusinessDetailsSearch;
use yii\web\Controller;
use yii\helpers\Url;
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
        if(!is_null($businessDetails)) {
            $session = Yii::$app->getSession();
            $origin = $session['origin'];
            $mode = $session['mode'];
            $map = $this->createMap($origin, $businessDetails, $mode);
        } else {
            Yii::$app->session->addFlash('error' , 'Something went wrong.');
            return $this->redirect(Url::toRoute('map/reset'));
        }
        
        return $this->render('view', 
            [
                'title' => (!is_null($businessDetails)) ? $businessDetails->name : null,
                'map' => isset($map) ? $map : null,
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