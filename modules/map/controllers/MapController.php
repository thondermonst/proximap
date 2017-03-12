<?php

namespace app\modules\map\controllers;

use app\modules\map\models\BusinessSearch;
use app\modules\map\models\Map;
use app\modules\map\models\PositionSearch;
use yii\web\Controller;
use Yii;

class MapController extends Controller
{

    /**
     * Default action
     */
    public function actionIndex() {
        return $this->view();
    }

    /**
     * View the map
     *
     * @return string
     */
    protected function view() {
        $types = $this->getTypes();

        $radii = $this->getRadii();

        if(Yii::$app->request->post() && null !== yii::$app->request->post('Map')) {
            $mapPost = yii::$app->request->post('Map');

            $map = $this->createMap($mapPost);

            //Set position
            $positionSearch = new PositionSearch();
            $position = $positionSearch->findByAddress($mapPost['search']);

            //Look for businesses
            $businessSearch = new BusinessSearch();
            $businesses = $businessSearch->find($position, $mapPost['type'], $mapPost['radius']);
        } else {
            $map = new Map();
            $map->setDefault();
        }

        return $this->render('view',
            [
                'title' => 'Map',
                'map' => $map,
                'types' => $types,
                'radii' => $radii,
                'businesses' => isset($businesses) ? $businesses : null,
            ]
        );
    }

    protected function getTypes() {
        return ['eat' => 'Eat', 'drink' => 'Drink', 'sleep' => 'Sleep'];
    }

    protected function getRadii() {
        return [1 => 1, 5 => 5, 10 => 10];
    }
    
    protected function createMap($params) {
        $map = new Map();
        
        $map->search = $params['search'];
        $map->type = $params['type'];
        $map->radius = $params['radius'];
        $map->setQueryAndSource();
        
        return $map;
    }
}