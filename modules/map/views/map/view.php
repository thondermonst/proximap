<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\map\assets\MapAsset;

$this->title = $title;
?>
<div id="map-container">
    <h1><?= \yii\helpers\Html::encode($title); ?></h1>
    <div id="search">
        <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($map, 'search')->textInput($map->search); ?>
            <?= $form->field($map, 'type')->dropDownList($types); ?>
            <?= $form->field($map, 'radius')->dropDownList($radii); ?>
            <?= Html::submitButton('Search') ?>
        <?php ActiveForm::end(); ?>
    </div>
    <div id="map">
        <iframe
                width="<?= $map->width; ?>"
                height="<?= $map->height; ?>"
                frameborder="0" style="border:0"
                src="<?= $map->baseUrl .  $map->apiKey . $map->query; ?>" allowfullscreen>
        </iframe>
    </div>
</div>
<?php
MapAsset::register($this);
?>
