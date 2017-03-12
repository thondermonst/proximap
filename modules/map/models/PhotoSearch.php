<?php

namespace app\modules\map\models;

use app\modules\map\models\AbstractModel;

class PhotoSearch extends AbstractModel
{
    public function findPhotoByReference($reference) {
        $apiUrl = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photoreference=' . $reference . '&key=' . $this->apiKey;
        
        return $apiUrl;
    }
}