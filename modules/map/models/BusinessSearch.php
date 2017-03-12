<?php

namespace app\modules\map\models;

use app\modules\map\models\Business;

class BusinessSearch extends AbstractModel
{

    /**
     * @param Position $position
     * @param string $type
     * @param integer $radiusInKm
     */
    public function find($position, $type, $radiusInKm) {
        switch ($type) {
            case 'eat':
                $type = 'restaurant';
                break;
            case 'drink':
                $type = 'cafe';
                break;
            case 'sleep';
                $type = 'lodging';
                break;
        }
        $radius = $radiusInKm * 1000;
        $apiUrl = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=' . $position->latitude . ',' . $position->longitude . /*'&radius=' . $radius . */'&rankby=distance&type=' . $type . '&key=' . $this->apiKey;
        
        $json = file_get_contents($apiUrl);

        $obj = json_decode($json);
        
        $businesses = [];
        foreach ($obj->results as $result) {
            $business = new Business();
            $business->name = $result->name;
            $business->address = $result->vicinity;
            $business->latitude = $result->geometry->location->lat;
            $business->longitude = $result->geometry->location->lng;
            $business->id = $result->place_id;
            $businesses[] = $business;
        }
        
        return $businesses;
    }
}