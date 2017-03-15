$( document ).ready(function() {
    var checked = $('#map-geolocation').attr('checked');
    toggleSearchInput(checked, false);

    $(':button').click(function() {
        disableSearchForm();
    });

    $('#map-geolocation').change(function() {
        toggleSearchInput(this.checked, true);
    });

    function disableSearchForm() {
        $(':input').attr('readonly','readonly');
        $(':button').addClass('disabled');
    }

    function toggleSearchInput(checked, reload) {
        if(checked) {
            if(reload) {
                disableSearchForm();

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var lat = position.coords.latitude;
                        var lng = position.coords.longitude;

                        window.location.href = '?r=map/map/get-address&lat=' + lat + '&long=' + lng;
                    }, function() {
                        handleLocationError(true);
                    });
                } else {
                    // Browser doesn't support Geolocation
                    handleLocationError(false);
                }
            } else {
                $('#map-search').attr('readonly','readonly');
            }
        } else {
            $('#map-search').removeAttr('readonly');
        }
    }

    function handleLocationError(browserHasGeolocation) {
        console.log(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
    }
});
