jQuery( function ( $ ) {
	// FitVids
	$('.entry').fitVids();

    // Toggle the search
    $('.search-toggle .dashicons-search').on( 'click', function() {
    	$(this)
    		.toggleClass('dashicons-no-alt')
    		.toggleClass('dashicons-search')
    		.next('.search-form').toggle()
            .parent('.search-toggle').toggleClass('open');
    });

});