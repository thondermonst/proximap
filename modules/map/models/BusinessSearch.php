<?php

namespace app\modules\map\models;

use yii\helpers\Url;
use Yii;

class BusinessSearch extends AbstractModel
{
    /**
     * @param Position $position
     * @param string $type
     * @param string $mode
     * @param integer $radiusInKm
     * @return array
     */
    public function find($position, $type, $mode, $radiusInKm) {
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
        $apiUrl = 'https://maps.googleapis.com/maps/api/place/radarsearch/json?location=' . $position->latitude . ',' . $position->longitude . '&radius=' . $radius . '&type=' . $type . '&key=' . $this->apiKey;

        $json = file_get_contents($apiUrl);

        $obj = json_decode($json);

        if($obj->status == 'OK') {
            $businesses = [];
            foreach ($obj->results as $result) {
                $business = new Business();
                $business->id = $result->place_id;
                $businessDetailsSearch = new BusinessDetailsSearch();
                $businessDetails = $businessDetailsSearch->findById($result->place_id, 'short');
                if(!is_null($businessDetails)) {
                    $business->name = $businessDetails->name;

                    $positionSearch = new PositionSearch();
                    $businessPosition = $positionSearch->findByCoordinates($result->geometry->location->lat, $result->geometry->location->lng);

                    $business->address = $businessPosition->address;
                    $business->latitude = $result->geometry->location->lat;
                    $business->longitude = $result->geometry->location->lng;
                    $business->distanceFromOrigin = $this->setDistanceFromOrigin($position, $business, $mode);
                    $businesses[] = $business;
                } else {
                    return null;
                }
            }

            usort($businesses, array($this, "cmp"));

            return $businesses;
        }

        return null;

    }

    /**
     * @param Position $origin
     * @param Business $business
     * @param string $mode
     * @return integer
     */
    protected function setDistanceFromOrigin($origin, $business, $mode) {
        $apiUrl = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $origin->latitude . ',' . $origin->longitude . '&destinations=' . $business->latitude . ',' . $business->longitude . '&mode=' . $mode .  '&key=' . $this->apiKey;

        $json = file_get_contents($apiUrl);

        $obj = json_decode($json);

        return $obj->rows[0]->elements[0]->distance->value;
    }

    /**
     * @param Business $a
     * @param Business $b
     * @return bool
     */
    protected function cmp($a, $b) {
        return $a->distanceFromOrigin > $b->distanceFromOrigin;
    }
}