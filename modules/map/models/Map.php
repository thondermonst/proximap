<?php
namespace app\modules\map\models;

class Map extends AbstractModel
{
    /**
     * @var string
     */
    public $baseUrl = 'https://www.google.com/maps/embed/v1/place?key=';

    /**
     * @var string
     */
    public $search;

    /**
     * @var string
     */
    public $type;

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
    
    public function setDefault()
    {
        $this->search = 'Bredabaan 780A Merksem';
        $this->setQueryAndSource();
    }
    
    public function setQueryAndSource() {
        $this->setQuery();
        $this->setSource();
    }

    public function setQuery() {
        $this->query = '&q=' . str_replace(' ', '+', $this->search);
    }
    
    public function setSource() {
        $this->source = $this->baseUrl . $this->apiKey . $this->query;
    }
}