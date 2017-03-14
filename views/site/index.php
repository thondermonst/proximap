<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Tom\'s Tools';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Tom's Tools</h1>

        <p class="lead">Check out various modules I have tinkered together as development excercises.</p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Map</h2>

                <p>Looking for a drink? A bite to eat? Somewhere to sleep? The Map module uses various Google Maps API's to display maps, 
                    directions and business details. Due to the strict quota Google applies, it is possible it isn't working.</p>

                <p><a class="btn btn-default" href="<?= Url::toRoute(['map/map']); ?>">Go to the Map module</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Twitter</h2>

                <p>Playing around with the current Twitter API and the Codebird PHP library. Some functionality may require an active Twitter account. As it connects to Twitter, be careful and use at your own risk.</p>

                <p><a class="btn btn-default" href="<?= Url::toRoute(['twitter/index/index']); ?>">Go to the Twitter module</a></p>
            </div>
        </div>

    </div>
</div>
