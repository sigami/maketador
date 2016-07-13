jQuery(function( $ ) {
    var affixElement = '#fixed-nav';
    $(affixElement).affix({
        offset: {
            top: $('#masthead').height()
        }
    });
});
