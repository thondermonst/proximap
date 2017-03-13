$( document ).ready(function() {    
    $(':button').click(function() {
        $(':input').attr('readonly','readonly');
        $(':button').addClass('disabled');
    });
});
