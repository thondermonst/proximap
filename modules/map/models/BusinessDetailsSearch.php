<?php

namespace app\modules\map\models;

use app\modules\map\models\BusinessDetails;
use app\modules\map\models\PhotoSearch;

class BusinessDetailsSearch extends AbstractModel 
{
    protected $days = [0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday'];

    public function findById($id, $type = 'full') {
        $apiUrl = 'https://maps.googleapis.com/maps/api/place/details/json?placeid=' . $id . '&key=' . $this->apiKey;
        
        $json = file_get_contents($apiUrl);
        
        $obj = json_decode($json);

        if($obj->status == 'OK') {
            $businessDetails = new BusinessDetails();
            $businessDetails->name = $obj->result->name;

            if($type == 'full') {
                $positionSearch = new PositionSearch();
                $businessPosition = $positionSearch->findByCoordinates($obj->result->geometry->location->lat, $obj->result->geometry->location->lng);

                $businessDetails->address = $businessPosition->address;
                $businessDetails->opening_hours = isset($obj->result->opening_hours) ? $this->formatOpeningHours($obj->result->opening_hours) : null;
                $businessDetails->url = $obj->result->url;
                $businessDetails->phone = isset($obj->result->international_phone_number) ? $obj->result->international_phone_number : null;
                $businessDetails->website_url = isset($obj->result->website) ? $obj->result->website : null;
                if(isset($obj->result->website)) {
                    $websiteParts = explode('?', $businessDetails->website_url);
                    $businessDetails->website = $websiteParts[0];
                } else {
                    $businessDetails->website = null;
                }
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
                $businessDetails->reviews = isset($obj->result->reviews) ? $obj->result->reviews : null;
            }

            return $businessDetails;
        }

        return null;
    }

    protected function formatOpeningHours($openingsHours) {
        $formattedOpeningsHours = [];
        $x = 0;
        foreach($openingsHours->periods as $item) {
            if(!isset($formattedOpeningsHours[$item->open->day]['fullname'])) {
                $formattedOpeningsHours[$item->open->day]['fullname'] = $this->days[$item->open->day];
                $x = 0;
            }

            $formattedOpeningsHours[$item->open->day]['periods'][$x]['open'] = $this->formatTime($item->open->time);
            $formattedOpeningsHours[$item->open->day]['periods'][$x]['close'] = $this->formatTime($item->close->time);
            $x++;
        }

        return $formattedOpeningsHours;
    }

    protected function formatTime($time) {
        return substr($time, 0, 2) . ':' . substr($time, 2, 2);
    }
}

