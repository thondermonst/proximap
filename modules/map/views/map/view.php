<?php

use yii\bootstrap\Button;
use yii\widgets\ActiveForm;
use app\modules\map\assets\MapAsset;
use yii\helpers\Url;

$this->title = $title;
?>
<div id="map-container">
    <h1><?= \yii\helpers\Html::encode($title); ?></h1>
    <?php $form = ActiveForm::begin(); ?>
    <div id="search">    
        <div class="form-element col-md-4">
            <?= $form->field($map, 'search')->textInput(['value' => $map->search]); ?>
        </div>
        <div class="form-element col-md-3">
            <?= $form->field($map, 'type')->dropDownList($types, ['value' => $map->type]); ?>
        </div>
        <div class="form-element col-md-3">
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
            <a href="<?= Url::toRoute(['focus/index', 'id' => $business->id]); ?>">
            <li class="col-md-3">
                <div class="business">
                    <?= $business->name; ?><br />
                    <?= $business->address; ?>
                </div>       
            </li>
            </a>
        <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>
</div>
<?php
MapAsset::register($this);
?>
