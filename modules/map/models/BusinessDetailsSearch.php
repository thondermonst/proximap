<?php

namespace app\modules\map\models;

use app\modules\map\models\BusinessDetails;
use app\modules\map\models\PhotoSearch;

class BusinessDetailsSearch extends AbstractModel 
{
    public function findById($id) {
        $apiUrl = 'https://maps.googleapis.com/maps/api/place/details/json?placeid=' . $id . '&key=' . $this->apiKey;
        
        $json = file_get_contents($apiUrl);
        
        $obj = json_decode($json);
        $businessDetails = new BusinessDetails();
        $businessDetails->name = $obj->result->name;

        $positionSearch = new PositionSearch();
        $businessPosition = $positionSearch->findByCoordinates($obj->result->geometry->location->lat, $obj->result->geometry->location->lng);

        $businessDetails->address = $businessPosition->address;
        $businessDetails->opening_hours = isset($obj->result->opening_hours->weekday_text) ? $obj->result->opening_hours->weekday_text : null;
        $businessDetails->url = $obj->result->url;
        $businessDetails->phone = isset($obj->result->international_phone_number) ? $obj->result->international_phone_number : null;
        $businessDetails->website = isset($obj->result->website) ? $obj->result->website : null;
        if(isset($obj->result->photos)) {
            $businessDetails->photos = [];
            $photoSearch = new PhotoSearch();
            foreach($obj->result->photos as $photo_result) {
                $photo = $photoSearch->findPhotoByReference($photo_result->photo_reference);
                $businessDetails->photos[] = $photo;
            }
        } else {
            $businessDetails->photos = null;
        }
        $businessDetails->rating = isset($obj->result->rating) ? $obj->result->rating : null;

        return $businessDetails;
    }
}

