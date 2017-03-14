<?php
use yii\web\View;
?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= Yii::$app->params['gmapApiKey']; ?>&callback=initMap"></script>
<div id="map-container">
    <h1>Test</h1>
    <div id="map"></div>
</div>
<?php
$script = <<<JS
    function initMap() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                
                $.ajax({
                    url: '?r=map/map/get-address',
                    data: {lat: pos.lat, long: pos.lng},
                }).done(function (data) {
                    $('#map').html(data);
                });
            }, function() {
                handleLocationError(true);
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false);
        }
    }
    
    function handleLocationError(browserHasGeolocation) {
        console.log(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
    }
JS;

$style = <<<CSS
    #map {
        height: 400px;
    }
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }    
CSS;
$this->registerCss($style);
$this->registerJS($script, View::POS_HEAD);
?>

