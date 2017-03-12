<?php

namespace app\modules\map\models;

class BusinessDetails extends AbstractModel 
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
     * @var string
     */
    public $url;
    
    /**
     * @var stdClass 
     */
    public $opening_hours;
    
    /**
     * @var string 
     */
    public $phone;
    
    /**
     * @var string
     */
    public $website;
    
    /**
     * @var array
     */
    public $photos;
    
    /**
     * @var float
     */
    public $rating;
}

