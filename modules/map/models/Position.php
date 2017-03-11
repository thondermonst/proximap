<?php

namespace app\modules\map\models;

class Position extends AbstractModel
{
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
}