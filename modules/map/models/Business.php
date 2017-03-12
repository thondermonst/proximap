<?php

namespace app\modules\map\models;

class Business extends AbstractModel
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $address;

    /**
     * @var float
     */
    public $longitude;

    /**
     * @var float
     */
    public $latitude;
    
    /**
     * @var string
     */
    public $id;
}