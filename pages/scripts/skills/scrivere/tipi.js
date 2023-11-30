$(document).ready(function() {

	$('.score').click(function() {

		const self = $(this);

		self.parents('.score-box').find('.filler-inp').prop('checked', false).change();
		self.find('.filler-inp').prop('checked', true).change();

	});

});