$(document).ready(function() {
	// Main sldier
	$('#main-slider-inner').bxSlider();

	// Slider product
	$('#viewport').bxSlider({
	  pagerCustom: '#bx-pager'
	});


	// Tabs

	$('.item-tab:gt(0)').hide();

	$('.head-tabs ul').on('click', 'li', function(event) {
		event.preventDefault();
		/* Act on the event */
		$('.head-tabs ul li').removeClass('active');
		$(this).addClass('active')
	});

	$('.head-tabs ul').on('click', 'a', function(event) {
		event.preventDefault();
		/* Act on the event */
		var nametabs= $(this).data('loc');

		console.log(nametabs);
		$('.item-tab').hide();

		$('#' + nametabs).fadeIn();

	});

	// Select
	$('.list').fancySelect();
});