<?php

use yii\bootstrap\Button;
use yii\widgets\ActiveForm;
use app\modules\map\assets\MapAsset;
use yii\helpers\Url;

$this->title = $title;
?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?= $map->apiKey; ?>&libraries=places&language=nl_BE"></script>
<div id="map-container">
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissible">
            <?php $flashes= Yii::$app->session->getFlash('error', null, false);
            foreach($flashes as $key=>$flash){
                echo '<div class="alert-'.$key.'">'.$flash.'</div>';
            }?>
        </div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible">
            <?php $flashes= Yii::$app->session->getFlash('success', null, false);
            foreach($flashes as $key=>$flash){
                echo '<div class="alert-'.$key.'">'.$flash.'</div>';
            } ?>
        </div>
    <?php endif; ?>
    <?php if($reset) : ?>
    <div id="back">
        <a href="<?= Url::toRoute(['map/reset']);?>">
            <button class="btn btn-danger">
                Reset
            </button></a>
    </div>
    <?php endif; ?>
    <h1><?= \yii\helpers\Html::encode($title); ?></h1>
    <?php $form = ActiveForm::begin(); ?>
    <div id="search">    
        <div class="form-element col-md-4">
            <?= $form->field($map, 'search')->textInput(['value' => $map->search]); ?>
        </div>
        <div class="form-element col-md-2">
            <?= $form->field($map, 'type')->dropDownList($types, ['value' => $map->type]); ?>
        </div>
        <div class="form-element col-md-2">
            <?= $form->field($map, 'mode')->dropDownList($modes, ['value' => $map->mode]); ?>
        </div>
        <div class="form-element col-md-2">
            <?= $form->field($map, 'radius')->dropDownList($radii, ['value' => $map->radius]); ?>
        </div>
        <div class="form-element col-md-2 search-button-element">
            <?= Button::widget(["label" => "Search", "options" => ["class" => "btn-primary grid-button search-button"]]); //Html::submitButton('Search') ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <div id="map">
        <iframe
                width="100%"
                height="<?= $map->height; ?>"
                frameborder="0" style="border:0"
                src="<?= $map->source; ?>" allowfullscreen>
        </iframe>
    </div>
    <?php if(!is_null($businesses)) : ?>
    <div id="businesses">
        <h2>Search results:</h2>
        <ul>
        <?php foreach($businesses as $business) : ?>
            <div class="col-md-3">
                <a href="<?= Url::toRoute(['focus/index', 'id' => $business->id]); ?>">
                    <li class="business">
                        <span class="name"><?= $business->name; ?></span>
                        <span class="address"><?= $business->address; ?></span>
                        <span class="distance"><?= round($business->distanceFromOrigin / 1000, 2); ?> km from your origin.</span>
                    </li>
                </a>
            </div>
        <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
</div>
<?php
$script = <<<JS
    var autocomplete = new google.maps.places.Autocomplete($("#map-search")[0], {});

    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        var place = autocomplete.getPlace();
        console.log(place.address_components);
    });
JS;
$this->registerJs($script);
MapAsset::register($this);
?>
