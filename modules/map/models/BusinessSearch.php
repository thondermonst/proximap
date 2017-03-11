<?php

namespace app\modules\map\models;

class BusinessSearch extends AbstractModel
{

    /**
     * @param Position $position
     * @param string $type
     * @param integer $radius
     */
    public function find($position, $type, $radius) {
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
        $radius = $radius * 1000;
        $apiUrl = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=' . $position->latitude . ',' . $position->longitude . '&radius=' . $radius . '&type=restaurant' . $type . '&key=' . $this->apiKey;

        $json = file_get_contents($apiUrl);

        $obj = json_decode($json);

        return $obj;
    }
}