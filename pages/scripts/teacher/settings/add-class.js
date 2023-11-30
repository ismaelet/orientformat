$(document).ready(function () {
	$('.js-school').on('change', async function () {
		const schoolId = $(this).val()
		const response = await AJAX('grade-list', { schoolId: schoolId }, 'text')

		$('.js-grade-container').html(response)
		$('.js-collaborate').prop('disabled', false)
	})
})
