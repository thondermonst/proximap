<?php

namespace app\modules\map\assets;

use yii\web\AssetBundle;

class MapAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/map/assets/';
    public $css = [
        'css/map.css',
    ];
    public $js = [
        'js/map.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}