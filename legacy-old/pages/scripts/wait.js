$(window).on('load', function() {

	const counter = $('#countdown .number');
	var countdown = 10;

	counter.html(countdown);

	setInterval(function() {

		countdown--;

		counter.html(countdown);

		if (countdown < 1) {
			location.reload();
		}

	}, 1000);

});