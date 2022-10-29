jQuery(function($){
    $('#start_date').datepicker({'showAnim': 'slideDown'});
    $('#end_date').datepicker({'showAnim': 'slideDown'});

    $('#setting-error-settings_updated button').click(function(){
        $('#setting-error-settings_updated').hide();
    });
});