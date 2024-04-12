$(document).ready(function () {
	var dotStart, dotEnd
	var xStart, yStart, xEnd, yEnd
	var xLast, yLast

	var startID = 0
	var endID = 0
	var mOld = false
	var qOld = false
	var started = false
	var completed = false

	var canvPerm = document.getElementById('canv-perm')
	var canvDraw = document.getElementById('canv-draw')

	var i = 0
	var tracking = 0

	var graph = $('#page-graph')

	// on page load
	drawing()
	resizeCanvas()
	recover()

	// on window resize
	$(window).resize(function () {
		resizeCanvas()
	})

	// store owner elements
	$('.dot-space').mouseup(function (e) {
		var ele = $(this)
		var dot = ele.find('.dot')

		if ($('#field').val() == '0') {
			$('#field').val(dot.data('id'))
		} else {
			$('#field').val($('#field').val() + ',' + dot.data('id'))
		}

		// fix a point
		if (started) {
			dotEnd = dot
			endID = dot.data('id')

			// save ending position
			xEnd = dot.offset().left - graph.offset().left + dot.width() / 2
			yEnd = dot.offset().top - graph.offset().top + dot.height() / 2

			// draw line if moved
			if (startID !== endID) {
				var x = e.pageX - graph.offset().left
				var y = e.pageY - graph.offset().top

				clear(canvDraw)

				draw_line(xEnd, yEnd, x, y, canvDraw)

				select(dotStart, 1)
				select(dotEnd, 1)

				draw_line(xStart, yStart, xEnd, yEnd, canvPerm)

				line_overlap(dotStart, dotEnd)

				xStart = xEnd
				yStart = yEnd
				dotStart = dotEnd
				startID = endID
			}

			// start drawing
		} else {
			if (!completed) {
				if (i == 4) {
					i = 0

					// blank canvas
					clear(canvPerm)

					$('.dot').data('active', 0)
					$('.dot').removeClass('active')
					$('.dot').removeClass('err')
					$('.tracking-inp').val(0).change()

					tracking = 0

					mOld = false
					qOld = false

					progress()

					xLast = e.pageX - graph.offset().left
					yLast = e.pageY - graph.offset().top
				} else {
					started = true
					dotStart = dot
					startID = dotStart.data('id')

					// blank canvas
					clear(canvPerm)

					$('.dot').data('active', 0)
					$('.dot').removeClass('active')
					$('.dot').removeClass('err')

					xLast = e.pageX - graph.offset().left
					yLast = e.pageY - graph.offset().top

					// save starting position
					xStart = dot.offset().left - graph.offset().left + dot.width() / 2
					yStart = dot.offset().top - graph.offset().top + dot.height() / 2
				}
			}
		}
	})

	// recover progress
	function recover() {
		const oldTrack = $('#field').val().split(',')

		if (oldTrack[0] != 0) {
			for (const id of oldTrack) {
				var dot = $('#dot-space' + id).find('.dot')

				// fix a point
				if (started) {
					dotEnd = dot
					endID = dot.data('id')

					// save ending position
					xEnd = dot.offset().left - graph.offset().left + dot.width() / 2
					yEnd = dot.offset().top - graph.offset().top + dot.height() / 2

					// draw line if moved
					if (startID !== endID) {
						select(dotStart, 1)
						select(dotEnd, 1)

						draw_line(xStart, yStart, xEnd, yEnd, canvPerm)

						line_overlap(dotStart, dotEnd)

						xStart = xEnd
						yStart = yEnd
						dotStart = dotEnd
						startID = endID
					}

					// start drawing
				} else {
					started = true
					dotStart = dot
					startID = dotStart.data('id')

					// blank canvas
					clear(canvPerm)

					$('.dot').data('active', 0)
					$('.dot').removeClass('active')
					$('.dot').removeClass('err')

					// save starting position
					xStart = dot.offset().left - graph.offset().left + dot.width() / 2
					yStart = dot.offset().top - graph.offset().top + dot.height() / 2
				}
			}
		}
	}

	// select dot
	function select(dot, active) {
		if (active === 1) {
			dot.data('active', 1)
			dot.addClass('active')
			dot.prev().val(1).change()
		} else {
			dot.data('active', 0)
			dot.removeClass('active')
		}
	}

	// check progress
	function progress() {
		var validN = 0

		$('.dot.tar').each(function () {
			validN += parseInt($(this).data('active'))
		})

		if (i == 4) {
			started = false

			clear(canvDraw)

			if (validN === 9) {
				completed = true

				$('#page-graph').addClass('disabled')
			} else {
				$('.dot.tar').addClass('err')
			}
		}

		$('#segments').text(i)
		$('#score').text(validN)
	}

	// check if the line pass through some points
	function line_overlap(start, end) {
		var x1 = parseInt(start.data('x'))
		var y1 = parseInt(start.data('y'))
		var x2 = parseInt(end.data('x'))
		var y2 = parseInt(end.data('y'))
		var m, q

		// calculate the line equation
		if (x2 !== x1) {
			m = (y2 - y1) / (x2 - x1)
			q = y1 - m * x1
		} else {
			m = false
			q = x1
		}

		// activate the dots that belong to the segment
		$('.dot').each(function () {
			var x = parseInt($(this).data('x'))
			var y = parseInt($(this).data('y'))

			// filter for line to segment
			if (x <= Math.max(x1, x2) && x >= Math.min(x1, x2) && y <= Math.max(y1, y2) && y >= Math.min(y1, y2)) {
				// check if they belong
				if (!m && x == q) {
					select($(this), 1)
				} else if (y === m * x + q) {
					select($(this), 1)
				}
			}
		})

		// add segment number if is not a longer version of what existed
		// if (m !== mOld || q !== qOld) {

		i++

		mOld = m
		qOld = q

		progress()
		// }
	}

	// draw line
	function draw_line(x1, y1, x2, y2, canv) {
		var ctx = canv.getContext('2d')

		ctx.beginPath()
		ctx.moveTo(x1, y1)
		ctx.lineTo(x2, y2)
		ctx.lineWidth = 2
		ctx.strokeStyle = '#fff'
		ctx.stroke()
	}

	// freehand draw
	function drawing() {
		var ctx
		var canv = $('#page-graph')
		var sDraw = false

		draw_setup()

		// draw_setup
		function draw_setup() {
			ctx = canvDraw.getContext('2d')

			canv.mousemove(function (e) {
				if (started) {
					var x = e.pageX - $(this).offset().left
					var y = e.pageY - $(this).offset().top

					draw(x, y, true)
				}
			})

			canv.mouseleave(function (e) {
				if (!completed) {
					mousePress = false
					started = false

					i = 0

					// blank canvas
					$('.dot').data('active', 0)
					$('.dot').removeClass('active')
					$('.dot').removeClass('err')
					$('.tracking-inp').val(0).change()

					tracking = 0

					mOld = false
					qOld = false

					progress()

					xLast = e.pageX - graph.offset().left
					yLast = e.pageY - graph.offset().top

					clear(canvDraw)
					clear(canvPerm)
				}
			})
		}

		// draw
		function draw(x, y, isDown) {
			if (isDown) {
				ctx.beginPath()
				ctx.strokeStyle = '#fff'
				ctx.lineWidth = 3
				ctx.lineJoin = 'round'
				ctx.moveTo(xLast, yLast)
				ctx.lineTo(x, y)
				ctx.closePath()
				ctx.stroke()
			}

			xLast = x
			yLast = y
		}
	}

	// clear canvas
	function clear(canv) {
		var ctx = canv.getContext('2d')

		ctx.setTransform(1, 0, 0, 1, 0, 0)
		ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height)
	}

	// resize canvas
	function resizeCanvas() {
		canvDraw.style.width = '100%'
		canvDraw.style.height = '100%'
		canvPerm.style.width = '100%'
		canvPerm.style.height = '100%'

		canvDraw.width = canvDraw.offsetWidth
		canvDraw.height = canvDraw.offsetHeight
		canvPerm.width = canvPerm.offsetWidth
		canvPerm.height = canvPerm.offsetHeight
	}
})
