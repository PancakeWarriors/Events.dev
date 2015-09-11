jQuery(document).ready(function($) {

	$(".headroom").headroom({
		"tolerance": 20,
		"offset": 50,
		"classes": {
			"initial": "animated",
			"pinned": "slideDown",
			"unpinned": "slideUp"
		}
	});

	/* Downloads 2 GA */
	var baseHref = '';
	if ( $('base').attr('href') != undefined )
		baseHref = $('base').attr('href');
	$('a.btn-download').each(function() {
		var href = $(this).attr('href');
		if ( href && href.match( /\.zip$/i ) ) {
			$(this).click(function() {
				var filename = href.replace( /^.*[\\\/]/, '');
				ga( 'send', 'event', 'Download', filename );
				if ( $(this).attr('target') != undefined && $(this).attr('target').toLowerCase() != '_blank' ) {
					setTimeout(function() { location.href = baseHref + href; }, 200);
					return false;
				}
			});
		}
	});


});