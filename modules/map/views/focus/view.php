<?php

use yii\bootstrap\Button;
use yii\widgets\ActiveForm;
use app\modules\map\assets\MapAsset;
use yii\helpers\Url;

$this->title = $title;
?>
<div id="map-container">
    <div id="back">
        <a href="<?= Url::previous();?>">
            <button class="btn btn-primary">
                Back to overview
            </button></a>
    </div>
    <h1><?= \yii\helpers\Html::encode($title); ?></h1>
    <div id="map">
        <iframe
                width="100%"
                height="<?= $map->height; ?>"
                frameborder="0" style="border:0"
                src="<?= $map->source; ?>" allowfullscreen>
        </iframe>
    </div>
    <div id="business-details">
        <h2>Business Details</h2>
        <div class="row">
            <div id="address" class="col-md-4">
                <h3>Address</h3>
                <?= $businessDetails->address; ?>
            </div>
            <div id="contact" class="col-md-4">
                <h3>Contact</h3>
                <ul>
                    <?php if(!is_null($businessDetails->phone)) : ?>
                    <li><strong>Phone:</strong> <?= $businessDetails->phone; ?></li>
                    <?php endif; ?>
                    <?php if(!is_null($businessDetails->website)) : ?>
                    <li><strong>Website:</strong> <a href="<?= $businessDetails->website_url; ?>" target="_blank"><?= $businessDetails->website; ?></a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div id="rating" class="col-md-4">
                <h3>Rating</h3>
                <?php if(!is_null($businessDetails->rating)) : ?>
                <div class="lead">
                    <div id="stars-existing" class="starrr" data-rating='<?= $businessDetails->rating; ?>'></div>
                </div>
                <?php else :  ?>
                    No rating available.
                <?php endif; ?>
            </div>            
        </div>
        <div class="row">
            <div id="openingshours" class="col-md-4">
                <h3>Opening Hours</h3>
                <?php if(!is_null($businessDetails->opening_hours)) : ?>
                <ul>
                <?php foreach($businessDetails->opening_hours as $day) : ?>
                    <li><?= $day; ?></li>
                <?php endforeach; ?>
                </ul>
                <?php else : ?>
                No information available.
                <?php endif; ?>
            </div>
            <div id="reviews" class="col-md-4">
                <h3>Reviews</h3>
                <?php if(!is_null($businessDetails->reviews)) : ?>
                <ul>
                    <?php foreach($businessDetails->reviews as $review) : ?>
                    <div class="review">
                        <div id="stars-existing" class="starrr" data-rating='<?= $review->aspects[0]->rating; ?>'></div>
                        <?= $review->text; ?><br />
                        <span class="author"><?= $review->author_name; ?></span>
                    </div>
                    <?php endforeach; ?>
                </ul>
                <?php else : ?>
                No reviews available.
                <?php endif; ?>
            </div>
            <div id="photos" class="col-md-4">
                <h3>Photos</h3>
                <?php if(!is_null($businessDetails->photos)) : ?>
                <?php foreach($businessDetails->photos as $photo) : ?>
                    <img src="<?= $photo; ?>" /><br /><br />
                <?php endforeach; ?>
                <?php else : ?>
                No photos available.
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
MapAsset::register($this);
?>