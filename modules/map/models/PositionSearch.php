<?php

namespace app\modules\map\models;

class PositionSearch extends AbstractModel
{

    public function findByAddress($entry) {
        $address = str_replace(' ', '+', $entry);

        $apiUrl = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&key=' . $this->apiKey;

        $json = file_get_contents($apiUrl);

        $obj = json_decode($json);

        foreach($obj->results as $result) {
            $position = new Position();

            $position->address = $result->formatted_address;
            $position->longitude = $result->geometry->location->lng;
            $position->latitude = $result->geometry->location->lat;

            break;
        }

        return $position;
    }
    
    public function findByCoordinates($latitude, $longitude) {
        $apiUrl = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $latitude . ',' . $longitude . '&key=' . $this->apiKey;
        
        $json = file_get_contents($apiUrl);
        
        $obj = json_decode($json);
        
        print '<pre>';
        var_dump($obj->results);
        print '</pre>';
        die();
    }
}