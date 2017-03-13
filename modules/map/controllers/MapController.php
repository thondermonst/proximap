<?php

namespace app\modules\map\controllers;

use app\modules\map\models\BusinessSearch;
use app\modules\map\models\Map;
use app\modules\map\models\PositionSearch;
use yii\web\Controller;
use Yii;
use yii\web\Session;

class MapController extends Controller
{
    /**
     * @var boolean
     */
    protected $reset;

    /**
     * Default action
     */
    public function actionIndex() {
        $session = Yii::$app->getSession();
        if(isset($session['map'])) {
            $this->reset = true;
        } else {
            $this->reset = false;
        }

        return $this->view();
    }

    public function actionReset() {
        $this->reset = false;
        $session = Yii::$app->getSession();
        unset($session['mapPost']);
        unset($session['map']);
        unset($session['origin']);
        unset($session['businesses']);
        unset($session['mode']);

        return $this->view();
    }

    /**
     * View the map
     *
     * @return string
     */
    protected function view() {
        $types = $this->getTypes();
        $modes = $this->getModes();
        $radii = $this->getRadii();

        //Use session for returning to overview
        if(Yii::$app->request->post() && null !== yii::$app->request->post('Map')) {
            $mapPost = yii::$app->request->post('Map');
            //overwrite session
            $session = Yii::$app->getSession();
            $session['mapPost'] = $mapPost;
        } else {
            //Check session
            $session = Yii::$app->getSession();
            if(isset($session['mapPost'])) {
                $mapPost = $session['mapPost'];
                $map = $session['map'];
                $businesses = $session['businesses'];
            }
        }

        if(isset($mapPost)) {
            if(!isset($map)) {
                $map = $this->createMap($mapPost);

                //Set position
                $positionSearch = new PositionSearch();
                $position = $positionSearch->findByAddress($mapPost['search']);

                //Look for businesses
                $businessSearch = new BusinessSearch();
                $businesses = $businessSearch->find($position, $mapPost['type'], $mapPost['mode'], $mapPost['radius']);

                //Set in session
                $session['map'] = $map;
                $session['origin'] = $position;
                $session['businesses'] = $businesses;
                $session['mode'] = $mapPost['mode'];

                $this->reset = true;
            }
        } else {
            $map = new Map();
            $map->setDefault();
        }

        return $this->render('view',
            [
                'reset' => $this->reset,
                'title' => 'Map',
                'map' => $map,
                'types' => $types,
                'modes' => $modes,
                'radii' => $radii,
                'businesses' => isset($businesses) ? $businesses : null,
            ]
        );
    }

    protected function getTypes() {
        return ['eat' => 'Eat', 'drink' => 'Drink', 'sleep' => 'Sleep'];
    }

    protected function getModes() {
        return ['walking' => 'Walking', 'driving' => 'Driving', 'bicycling' => 'Bicycling', 'transit' => 'Public Transport'];
    }

    protected function getRadii() {
        return [1 => '1 km', 5 => '5 km', 10 => '10 km'];
    }
    
    protected function createMap($params) {
        $map = new Map();
        $map->search = $params['search'];
        $map->type = $params['type'];
        $map->mode = $params['mode'];
        $map->radius = $params['radius'];
        $map->setQueryAndSourceForPlace();
        
        return $map;
    }
}