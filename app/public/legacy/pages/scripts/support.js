$(document).ready(function () {
	resize_content()

	$(window).on('resize', function () {
		resize_content()
	})

	function resize_content() {
		$('.js-topic-text').each(function () {
			const self = $(this)
			const contentHeight = self.prop('scrollHeight')

			self.css('--_content-height', contentHeight + 'px')
		})
	}

	$('.js-open-topic').click(function () {
		const topicBlock = $(this).parents('.js-topic')
		const id = topicBlock.data('id')
		const url = new URL(window.location)

		resize_content()

		if (topicBlock.hasClass('active')) {
			topicBlock.removeClass('active')
			url.searchParams.set('topic', '')
			url.hash = ''
		} else {
			topicBlock.addClass('active')
			url.searchParams.set('topic', id)
			url.hash = 'topic' + id
		}

		window.history.pushState({}, '', url)
	})

	$('.topic_img').click(function () {
		const imgUrl = $(this).attr('src')

		$('.modal-img').attr('src', imgUrl)
	})
})
