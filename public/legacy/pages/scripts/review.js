$(document).ready(function () {
	/*
	 * Checkbox change
	 */
	$('.js-cbx').on('change', function () {
		const self = $(this)
		const name = self.attr('name')
		const question = self.parents('.js-question')

		$('.js-cbx[name="' + name + '"]').prop('checked', false)
		self.prop('checked', true)

		completed_question(question)
	})

	/*
	 * Input change
	 */
	$('.js-input').on('keyup', function () {
		const self = $(this)
		const question = self.parents('.js-question')

		if (self.val()) {
			completed_question(question)
		}
	})

	/*
	 * Complete a question
	 */
	function completed_question(question) {
		const multiple = question.data('multiple')

		let completed = true

		if (multiple) {
			if (!question.find('.js-cbx:checked').length) {
				completed = false
			}
		} else {
			question.find('.js-cbx').each(function () {
				const name = $(this).attr('name')

				if (!question.find('.js-cbx[name="' + name + '"]:checked').length) {
					completed = false
				}
			})
		}

		if (completed) {
			question.data('completed', 1).addClass('question--completed')
			question.find('.js-error-warning').hide()
		} else {
			question.data('completed', 0).removeClass('question--completed')
		}
	}

	/*
	 * Check overall completition
	 */
	$('.js-attempt-submit').click(function () {
		let completed = true
		let missedQuestiondId

		$('.question').each(function () {
			if (!$(this).data('completed') && !$(this).data('optional')) {
				completed = false
				missedQuestiondId = $(this).attr('id')
				return false
			}
		})

		if (completed) {
			$('.js-submit').click()
		} else {
			const missedQuestion = $('#' + missedQuestiondId)

			missedQuestion.find('.js-error-warning').show()

			$('html, body').animate(
				{
					scrollTop: missedQuestion.offset().top,
				},
				500
			)
		}
	})

	/*
	 * Dependent questions
	 */
	$('#question-s2d2 .js-cbx').on('change', function () {
		const parsing = ['3a', '3b', '3c', '3d']
		const id = $(this).attr('name').split('_')[1]
		const questionSlug = 's2d' + parsing[id - 1]

		if ($(this).val() > 1) {
			$('#question-' + questionSlug)
				.show()
				.data('optional', 0)
		} else {
			$('#question-' + questionSlug)
				.hide()
				.data('optional', 1)
				.data('completed', 0)
				.removeClass('question--completed')
				.find('.js-cbx')
				.prop('checked', false)
		}
	})

	$('#question-s6d2 .js-cbx').on('change', function () {
		if ($(this).val() > 1) {
			$('#question-s6d3').show().data('optional', 0)
		} else {
			$('#question-s6d3').hide().data('optional', 1).data('completed', 0).removeClass('question--completed').find('.js-cbx').prop('checked', false)
		}
	})

	$('#question-s7d2 .js-cbx').on('change', function () {
		if ($(this).val() == 1) {
			$('#question-s7d3').show().data('optional', 0)
		} else {
			$('#question-s7d3').hide().data('optional', 1).data('completed', 0).removeClass('question--completed').find('.js-cbx').prop('checked', false)
		}

		if ($(this).val() == 2) {
			$('#question-s7d4').show().data('optional', 0)
			$('#question-s7d5').show().data('optional', 0)
		} else {
			$('#question-s7d4').hide().data('optional', 1).data('completed', 0).removeClass('question--completed').find('.js-cbx').prop('checked', false)
			$('#question-s7d5').hide().data('optional', 1).data('completed', 0).removeClass('question--completed').find('.js-cbx').prop('checked', false)
		}
	})
})
