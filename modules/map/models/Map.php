<?php
namespace app\modules\map\models;

class Map extends AbstractModel
{
    /**
     * @var string
     */
    public $placeUrl = 'https://www.google.com/maps/embed/v1/place?key=';

    /**
     * @var string
     */
    public $directionsUrl = 'https://www.google.com/maps/embed/v1/directions?key=';

    /**
     * @var string
     */
    public $search;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $mode;

    /**
     * @var integer
     */
    public $radius;

    /**
     * @var string
     */
    public $query;
    
    /**
     * @var string
     */
    public $source;
        
    /**
     * @var integer
     */
    public $height = 596;

    /**
     * @var integer
     */
    public $width = 996;

    /**
     * @var boolean
     */
    public $geolocation;

    public function setDefaultForPlace()
    {
        $this->search = 'Bredabaan 780A Merksem';
        $this->setQueryAndSourceForPlace();
    }

    public function setQueryAndSourceForPlace() {
        $this->setQueryForPlace();
        $this->setSourceForPlace();
    }

    public function setQueryForPlace() {
        $this->query = '&q=' . str_replace(' ', '+', $this->search);
    }

    public function setSourceForPlace() {
        $this->source = $this->placeUrl . $this->apiKey . $this->query;
    }

    public function setQueryAndSourceForDirections($origin, $destination, $mode) {
        $this->setQueryForDirections($origin, $destination, $mode);
        $this->setSourceForDirections();
    }

    public function setQueryForDirections($origin, $destination, $mode) {
        $this->query = '&origin=' . str_replace(' ', '+', $origin->address) . '&destination=' . str_replace(' ', '+', $destination->address) . '&mode=' . $mode;
    }

    public function setSourceForDirections() {
        $this->source = $this->directionsUrl . $this->apiKey . $this->query;
    }
}