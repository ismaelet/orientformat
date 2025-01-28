$(document).ready(function() {

	var curr_pos = 1;

	//fix height to avoid puzzle jump on mobile
	fix_height();

	$(window).resize(function() {fix_height();});
	
	function fix_height() {

		$('.title-box').css('height','auto');

		const maxHeight = Math.max.apply(null, $('.title-box').map(function() {

			return $(this).height();

		}).get());

		$('.title-box').height(maxHeight);
	}

	//puzzle pieces
	$('.piece-area').hover(function() {

		const pos = $(this).data('pos');
		
		$('.piece-area').not('#piece-area' + curr_pos).removeClass('active');
		$(this).addClass('active');
	
	}, function() {
		
		$('.piece-area').not('#piece-area' + curr_pos).removeClass('active');

	});

	$('.piece-area').click(function() {

		const pos = $(this).data('pos');
		curr_pos = pos;

		$('.piece-area').removeClass('active');
		$('.title-box').removeClass('active');
		
		$(this).addClass('active');
		$('#title-box' + pos).addClass('active');
	});

});