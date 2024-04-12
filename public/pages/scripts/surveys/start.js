$(document).ready(function () {
	// select only one per group
	$('.cbx').click(function () {
		const input = $(this).find('.cbx-mirror')
		const group = input.data('group')

		if (input.parents('.answers').hasClass('multiple')) {
		} else {
			$('[data-group="' + group + '"]').prop('checked', false)
			input.prop('checked', true)
		}
	})

	// submit button
	$('#submit-mirror').click(function () {
		check_completed()
	})

	// check that everything has an answer
	function check_completed() {
		var valid = true

		$('.question').each(function () {
			const self = $(this)

			const completed = parseInt(self.data('completed'))

			if (!completed) {
				valid = false

				self.find('.inp.err').show()

				$('html, body').animate(
					{
						scrollTop: self.offset().top,
					},
					1000
				)

				return false
			}
		})

		if (valid) {
			$('#submit').click()
		}
	}

	// section 2
	$('#question-s1d2 .cbx').click(function () {
		const cbx = $(this).find('.cbx-mirror')
		const group = cbx.data('group')
		const val = cbx.val()

		// show linked section
		if (group == 's1d2_1') {
			if (val > 1) {
				$('#question-s1d3a').removeClass('question--completed').data('visible', 1).show()
				if ($('#question-s1d3a input:checked').length) {
					$('#question-s1d3a').addClass('question--completed').data('completed', 1)
				} else {
					$('#question-s1d3a').removeClass('question--completed').data('completed', 0)
				}
			} else {
				$('#question-s1d3a').data('completed', 1).data('visible', 0).hide()
				$('#question-s1d3a').find('.cbx-mirror').prop('checked', false)
			}
		} else if (group == 's1d2_2') {
			if (val > 1) {
				$('#question-s1d3b').removeClass('question--completed').data('visible', 1).show()
				if ($('#question-s1d3b input:checked').length) {
					$('#question-s1d3b').addClass('question--completed').data('completed', 1)
				} else {
					$('#question-s1d3b').removeClass('question--completed').data('completed', 0)
				}
			} else {
				$('#question-s1d3b').data('completed', 1).data('visible', 0).hide()
				$('#question-s1d3b').find('.cbx-mirror').prop('checked', false)
			}
		} else if (group == 's1d2_3') {
			if (val > 1) {
				$('#question-s1d3c').removeClass('question--completed').data('visible', 1).show()
				if ($('#question-s1d3c input:checked').length) {
					$('#question-s1d3c').addClass('question--completed').data('completed', 1)
				} else {
					$('#question-s1d3c').removeClass('question--completed').data('completed', 0)
				}
			} else {
				$('#question-s1d3c').data('completed', 1).data('visible', 0).hide()
				$('#question-s1d3c').find('.cbx-mirror').prop('checked', false)
			}
		} else if (group == 's1d2_4') {
			if (val > 1) {
				$('#question-s1d3d').removeClass('question--completed').data('visible', 1).show()
				if ($('#question-s1d3d input:checked').length) {
					$('#question-s1d3d').addClass('question--completed').data('completed', 1)
				} else {
					$('#question-s1d3d').removeClass('question--completed').data('completed', 0)
				}
			} else {
				$('#question-s1d3d').data('completed', 1).data('visible', 0).hide()
				$('#question-s1d3d').find('.cbx-mirror').prop('checked', false)
			}
		}
	})

	// check if a question is completed
	$('.field').on('change', function () {
		$('.inp.err').hide()

		// question 1-1
		if ($('#question-s1d1 input:checked').length) {
			$('#question-s1d1').addClass('question--completed').data('completed', 1)
		} else {
			$('#question-s1d1').removeClass('question--completed').data('completed', 0)
		}

		// question 1-2
		if ($('[data-group="s1d2_1"]:checked').length && $('[data-group="s1d2_2"]:checked').length && $('[data-group="s1d2_3"]:checked').length && $('[data-group="s1d2_4"]:checked').length) {
			$('#question-s1d2').addClass('question--completed').data('completed', 1)
		} else {
			$('#question-s1d2').removeClass('question--completed').data('completed', 0)
		}

		// question 1-3 group
		if ($('#question-s1d3a input:checked').length) {
			$('#question-s1d3a').addClass('question--completed').data('completed', 1)
		} else {
			$('#question-s1d3a').removeClass('question--completed').data('completed', 0)
		}
		if ($('#question-s1d3b input:checked').length) {
			$('#question-s1d3b').addClass('question--completed').data('completed', 1)
		} else {
			$('#question-s1d3b').removeClass('question--completed').data('completed', 0)
		}
		if ($('#question-s1d3c input:checked').length) {
			$('#question-s1d3c').addClass('question--completed').data('completed', 1)
		} else {
			$('#question-s1d3c').removeClass('question--completed').data('completed', 0)
		}
		if ($('#question-s1d3d input:checked').length) {
			$('#question-s1d3d').addClass('question--completed').data('completed', 1)
		} else {
			$('#question-s1d3d').removeClass('question--completed').data('completed', 0)
		}

		// question 1-4
		if ($('[data-group="s1d4_1"]:checked').length && $('[data-group="s1d4_2"]:checked').length && $('[data-group="s1d4_3"]:checked').length && $('[data-group="s1d4_4"]:checked').length) {
			$('#question-s1d4').addClass('question--completed').data('completed', 1)
		} else {
			$('#question-s1d4').removeClass('question--completed').data('completed', 0)
		}

		// question 1-5
		if ($('[data-group="s1d5_1"]:checked').length && $('[data-group="s1d5_2"]:checked').length && $('[data-group="s1d5_3"]:checked').length && $('[data-group="s1d5_4"]:checked').length) {
			$('#question-s1d5').addClass('question--completed').data('completed', 1)
		} else {
			$('#question-s1d5').removeClass('question--completed').data('completed', 0)
		}

		// question 1-6
		if ($('[data-group="s1d6"]:checked').length) {
			$('#question-s1d6').addClass('question--completed').data('completed', 1)
		} else {
			$('#question-s1d6').removeClass('question--completed').data('completed', 0)
		}

		// question 1-7
		if (
			$('[data-group="s1d7_1"]:checked').length &&
			$('[data-group="s1d7_2"]:checked').length &&
			$('[data-group="s1d7_3"]:checked').length &&
			$('[data-group="s1d7_4"]:checked').length &&
			$('[data-group="s1d7_5"]:checked').length &&
			$('[data-group="s1d7_6"]:checked').length &&
			$('[data-group="s1d7_7"]:checked').length &&
			$('[data-group="s1d7_8"]:checked').length &&
			$('[data-group="s1d7_9"]:checked').length &&
			$('[data-group="s1d7_10"]:checked').length &&
			$('[data-group="s1d7_11"]:checked').length &&
			$('[data-group="s1d7_12"]:checked').length
		) {
			$('#question-s1d7').addClass('question--completed').data('completed', 1)
		} else {
			$('#question-s1d7').removeClass('question--completed').data('completed', 0)
		}

		// question 1-8
		if (
			$('[data-group="s1d8_1"]:checked').length &&
			$('[data-group="s1d8_2"]:checked').length &&
			$('[data-group="s1d8_3"]:checked').length &&
			$('[data-group="s1d8_4"]:checked').length &&
			$('[data-group="s1d8_5"]:checked').length &&
			$('[data-group="s1d8_6"]:checked').length &&
			$('[data-group="s1d8_7"]:checked').length &&
			$('[data-group="s1d8_8"]:checked').length &&
			$('[data-group="s1d8_9"]:checked').length
		) {
			$('#question-s1d8').addClass('question--completed').data('completed', 1)
		} else {
			$('#question-s1d8').removeClass('question--completed').data('completed', 0)
		}

		// question 1-9
		if (
			$('[data-group="s1d9_1"]:checked').length &&
			$('[data-group="s1d9_2"]:checked').length &&
			$('[data-group="s1d9_3"]:checked').length &&
			$('[data-group="s1d9_4"]:checked').length &&
			$('[data-group="s1d9_5"]:checked').length &&
			$('[data-group="s1d9_6"]:checked').length &&
			$('[data-group="s1d9_7"]:checked').length &&
			$('[data-group="s1d9_8"]:checked').length &&
			$('[data-group="s1d9_9"]:checked').length &&
			$('[data-group="s1d9_10"]:checked').length &&
			$('[data-group="s1d9_11"]:checked').length
		) {
			$('#question-s1d9').addClass('question--completed').data('completed', 1)
		} else {
			$('#question-s1d9').removeClass('question--completed').data('completed', 0)
		}

		// question 2-1
		if (
			$('[data-group="s2d1_1"]:checked').length &&
			$('[data-group="s2d1_2"]:checked').length &&
			$('[data-group="s2d1_3"]:checked').length &&
			$('[data-group="s2d1_4"]:checked').length &&
			$('[data-group="s2d1_5"]:checked').length &&
			$('[data-group="s2d1_6"]:checked').length &&
			$('[data-group="s2d1_7"]:checked').length &&
			$('[data-group="s2d1_8"]:checked').length &&
			$('[data-group="s2d1_9"]:checked').length &&
			$('[data-group="s2d1_10"]:checked').length &&
			$('[data-group="s2d1_11"]:checked').length
		) {
			$('#question-s2d1').addClass('question--completed').data('completed', 1)
		} else {
			$('#question-s2d1').removeClass('question--completed').data('completed', 0)
		}

		// question 2-2
		if (
			$('[data-group="s2d2_1"]:checked').length &&
			$('[data-group="s2d2_2"]:checked').length &&
			$('[data-group="s2d2_3"]:checked').length &&
			$('[data-group="s2d2_4"]:checked').length &&
			$('[data-group="s2d2_5"]:checked').length &&
			$('[data-group="s2d2_6"]:checked').length &&
			$('[data-group="s2d2_7"]:checked').length &&
			$('[data-group="s2d2_8"]:checked').length &&
			$('[data-group="s2d2_9"]:checked').length &&
			$('[data-group="s2d2_10"]:checked').length &&
			$('[data-group="s2d2_11"]:checked').length
		) {
			$('#question-s2d2').addClass('question--completed').data('completed', 1)
		} else {
			$('#question-s2d2').removeClass('question--completed').data('completed', 0)
		}

		// question 3-1
		if ($('[data-group="s3d1_ma"]:checked').length && $('[data-group="s3d1_pa"]:checked').length) {
			$('#question-s3d1').addClass('question--completed').data('completed', 1)
		} else {
			$('#question-s3d1').removeClass('question--completed').data('completed', 0)
		}

		// question 3-2
		if ($('[data-group="s3d2"]:checked').length) {
			$('#question-s3d2').addClass('question--completed').data('completed', 1)
		} else {
			$('#question-s3d2').removeClass('question--completed').data('completed', 0)
		}

		// question 3-3
		if ($('[data-group="s3d3_ma"]:checked').length && $('[data-group="s3d3_pa"]:checked').length) {
			$('#question-s3d3').addClass('question--completed').data('completed', 1)
		} else {
			$('#question-s3d3').removeClass('question--completed').data('completed', 0)
		}

		// question 3-4
		if ($('[data-group="s3d4_ma"]:checked').length && $('[data-group="s3d4_pa"]:checked').length) {
			$('#question-s3d4').addClass('question--completed').data('completed', 1)
		} else {
			$('#question-s3d4').removeClass('question--completed').data('completed', 0)
		}

		// question 3-5
		$('#question-s3d5').addClass('question--completed').data('completed', 1)

		// complete not visible
		$('.question').each(function () {
			if ($(this).data('visible') === 0) {
				$(this).data('completed', 1)
			}
		})
	})

	$('.field').keyup(function () {
		/*$('.inp.err').hide();

		// question 3-5
		if ($('[data-group="s3d5_ma"]').val() !== "" && $('[data-group="s3d5_pa"]').val() !== "") {
			$('#question-s3d5').addClass('question--completed').data('completed', 1);
		} else {
			$('#question-s3d5').removeClass('question--completed').data('completed', 0);
		}*/
	})
})
