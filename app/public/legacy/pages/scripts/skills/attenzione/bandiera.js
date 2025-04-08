$(document).ready(function() {

	$('#start').click(function() {

		start();

	});

	function start() {

		var seconds = 60;

		$('body').addClass('fixed');
		$('#backgrounds').fadeIn();

		var interval = setInterval(function() {

			--seconds;
			
			if (seconds >= 0) {

				var str = (seconds < 10) ? '0' + seconds : seconds;

				$('#countdown').html(str);

			} else {

				clearInterval(interval);

				$('#countdown').fadeOut();

				interlude();
			}

		}, 1000);
	}

	function interlude() {

		$('#blank').fadeIn();
		$('#interlude').fadeIn();

		setTimeout(function() {

			$('#interlude').fadeOut();

			memory();

		}, 5000);

	}

	function memory() {

		var seconds = 60;

		$('#countdown').html(seconds);
		$('#countdown').fadeIn();

		var interval = setInterval(function() {

			--seconds;
			
			if (seconds >= 0) {

				var str = (seconds < 10) ? '0' + seconds : seconds;

				$('#countdown').html(str);

			} else {

				clearInterval(interval);

				$('#countdown').fadeOut();
				$('#end').fadeIn();

			}

		}, 1000);
	}

});