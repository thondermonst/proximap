<?php

namespace app\modules\map\models;

use yii\base\Model;
use Yii;

class AbstractModel extends Model
{
    /**
     * @var string
     */
    public $apiKey;


    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->apiKey = Yii::$app->params['gmapApiKey'];
    }
}