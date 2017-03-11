<?php
namespace app\modules\map\models;

class Map extends AbstractModel
{
    /**
     * @var string
     */
    public $baseUrl;

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
     * @var integer
     */
    public $height;

    /**
     * @var integer
     */
    public $width;

    /**
     * Map constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->baseUrl = 'https://www.google.com/maps/embed/v1/place?key=';
        $this->query = '&q=Centraal+Station+Antwerpen';
        $this->width = 996;
        $this->height = 596;
    }

    public function setQuery($search) {
        $this->query = '&q=' . str_replace(' ', '+', $search);
    }
}