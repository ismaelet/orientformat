$(document).ready(function () {
	$('.cause').draggable({
		revert: function (event, ui) {
			if (!event) {
				$(this).animate({ top: '0px', left: '0px' }, 100)
			}
		},
	})

	$('.droppable').droppable({
		accept: '.cause',
		drop: function (event, ui) {
			const self = $(this)
			const eleID = '#' + ui.draggable.attr('id')
			const ele = $(eleID)

			if (self.hasClass('droppable') && ((ele.hasClass('reader') && self.hasClass('reader')) || (!ele.hasClass('reader') && !self.hasClass('reader')))) {
				const text = ele.find('p').html()

				ele.hide()

				self.find('.filler-inp').val(ele.data('id')).change()
				self.data('attached', eleID)
				self.addClass('active').removeClass('droppable')
				self.find('p').html(text)

				generate_lines()
			} else {
				ele.animate({ top: '0px', left: '0px' }, 100)
			}
		},
	})

	$('.reset').click(function () {
		const box = $(this).parent()
		const ele = $(box.data('attached'))

		box.removeClass('active').addClass('droppable')
		box.find('.filler-inp').val(0).change()
		box.find('p').html('')

		ele.css('top', 0).css('left', 0)
		ele.show()

		generate_lines()
	})

	//lines
	generate_lines()

	function generate_lines() {
		$('.leader-line').remove()

		let start, end

		start = document.getElementById('box2')
		end = document.getElementById('box5')
		new LeaderLine(start, end, { color: '#c14e6e', dash: { animation: true }, size: 4 })

		start = document.getElementById('box7')
		end = document.getElementById('box5')
		new LeaderLine(start, end, { startSocket: 'top', color: '#c14e6e', dash: { animation: true }, size: 4 })
		end = document.getElementById('box8')
		new LeaderLine(start, end, { startSocket: 'bottom', color: '#c14e6e', dash: { animation: true }, size: 4 })

		start = document.getElementById('box5')
		end = document.getElementById('box8')
		new LeaderLine(start, end, { color: '#c14e6e', dash: { animation: true }, size: 4 })

		start = document.getElementById('box8')
		end = document.getElementById('box11')
		new LeaderLine(start, end, { color: '#c14e6e', dash: { animation: true }, size: 4 })

		start = document.getElementById('box11')
		end = document.getElementById('box12')
		new LeaderLine(start, end, { color: '#c14e6e', dash: { animation: true }, size: 4 })
		end = document.getElementById('box14')
		new LeaderLine(start, end, { color: '#c14e6e', dash: { animation: true }, size: 4 })
		start = document.getElementById('box12')
		new LeaderLine(start, end, { startSocket: 'bottom', endSocket: 'top', color: '#c14e6e', dash: { animation: true }, size: 4 })

		start = document.getElementById('box15')
		end = document.getElementById('box14')
		new LeaderLine(start, end, { color: '#c14e6e', dash: { animation: true }, size: 4 })

		start = document.getElementById('box14')
		end = document.getElementById('box16')
		new LeaderLine(start, end, { endSocket: 'top', color: '#c14e6e', dash: { animation: true }, size: 4 })
		end = document.getElementById('box17')
		new LeaderLine(start, end, { color: '#c14e6e', dash: { animation: true }, size: 4 })

		start = document.getElementById('box16')
		end = document.getElementById('box17')
		new LeaderLine(start, end, { startSocket: 'bottom', color: '#c14e6e', dash: { animation: true }, size: 4 })

		start = document.getElementById('box17')
		end = document.getElementById('box18')
		new LeaderLine(start, end, { color: '#c14e6e', dash: { animation: true }, size: 4 })
	}
})
