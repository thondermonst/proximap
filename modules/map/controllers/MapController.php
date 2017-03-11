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
        $map = new Map();

        $types = $this->getTypes();

        $radii = $this->getRadii();

        if(Yii::$app->request->post() && null !== yii::$app->request->post('Map')) {
            $mapPost = yii::$app->request->post('Map');

            //Set map query
            $map->setQuery($mapPost['search']);

            //Set position
            $positionSearch = new PositionSearch();
            $position = $positionSearch->find($mapPost['search']);

            //Look for businesses
            $businessSearch = new BusinessSearch();
            $businesses = $businessSearch->find($position, $mapPost['type'], $mapPost['radius']);

            var_dump($mapPost);
            print '<pre>';
            var_dump($businesses);
            print '</pre>';
            die();


            $map->type = $mapPost['type'];
            $map->radius = $mapPost['radius'];
        }

        return $this->render('view',
            [
                'title' => 'Map',
                'map' => $map,
                'types' => $types,
                'radii' => $radii,
            ]
        );
    }

    protected function getTypes() {
        return ['eat' => 'Eat', 'drink' => 'Drink', 'sleep' => 'Sleep'];
    }

    protected function getRadii() {
        return [1 => 1, 5 => 5, 10 => 10];
    }
}