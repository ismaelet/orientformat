$(document).ready(function () {
	let start, end

	if ($(window).width() > 800) {
		//center cycles
		start = document.getElementById('box6')
		end = document.getElementById('box7')
		let line1 = new LeaderLine(start, end, {
			dash: { animation: true },
			startSocket: 'top',
			endSocket: 'top',
			hide: true,
			startPlugColor: '#849bbd',
			endPlugColor: '#dea1b2',
			gradient: true,
			size: 8,
		})
		let line2 = new LeaderLine(end, start, {
			dash: { animation: true },
			startSocket: 'bottom',
			endSocket: 'bottom',
			hide: true,
			startPlugColor: '#dea1b2',
			endPlugColor: '#849bbd',
			gradient: true,
			size: 8,
		})

		//level1
		start = document.getElementById('box6')
		end = document.getElementById('box4')
		let line3 = new LeaderLine(start, end, { path: 'magnet', hide: true, endSocket: 'right', color: '#849bbd', size: 4 })
		end = document.getElementById('box9')
		let line4 = new LeaderLine(start, end, { path: 'magnet', hide: true, endSocket: 'right', color: '#849bbd', size: 4 })

		start = document.getElementById('box7')
		end = document.getElementById('box5')
		let line5 = new LeaderLine(start, end, { path: 'magnet', hide: true, color: '#dea1b2', size: 4 })
		end = document.getElementById('box10')
		let line6 = new LeaderLine(start, end, { path: 'magnet', dash: true, hide: true, color: '#dea1b2', size: 4 })

		//level 2
		start = document.getElementById('box4')
		end = document.getElementById('box3')
		let line7 = new LeaderLine(start, end, { hide: true, color: '#849bbd', size: 4 })
		end = document.getElementById('box2')
		let line8 = new LeaderLine(start, end, { hide: true, endSocket: 'right', color: '#849bbd', size: 4 })
		end = document.getElementById('box1')
		let line9 = new LeaderLine(start, end, { hide: true, endSocket: 'right', color: '#849bbd', size: 4 })

		start = document.getElementById('box9')
		end = document.getElementById('box11')
		let line10 = new LeaderLine(start, end, { hide: true, color: '#849bbd', size: 4 })
		end = document.getElementById('box13')
		let line11 = new LeaderLine(start, end, { hide: true, endSocket: 'right', color: '#849bbd', size: 4 })

		start = document.getElementById('box8')
		end = document.getElementById('box5')
		let line12 = new LeaderLine(start, end, { path: 'magnet', endSocket: 'right', hide: true, color: '#dea1b2', size: 4 })
		end = document.getElementById('box10')
		let line13 = new LeaderLine(start, end, { path: 'magnet', endSocket: 'right', dash: true, hide: true, color: '#dea1b2', size: 4 })

		start = document.getElementById('box10')
		end = document.getElementById('box12')
		let line14 = new LeaderLine(start, end, { hide: true, startSocket: 'bottom', color: '#dea1b2', size: 4 })
		end = document.getElementById('box14')
		let line15 = new LeaderLine(start, end, { hide: true, startSocket: 'bottom', endSocket: 'left', color: '#dea1b2', size: 4 })

		//show lines
		setTimeout(function () {
			line1.show('draw', { duration: 600 })
			line2.show('draw', { duration: 600 })
		}, 200)

		setTimeout(function () {
			line3.show('draw', { duration: 600 })
			line4.show('draw', { duration: 600 })
			line5.show('draw', { duration: 600 })
			line6.show('draw', { duration: 600 })
		}, 600)

		setTimeout(function () {
			line7.show('draw', { duration: 600 })
			line10.show('draw', { duration: 600 })
			line12.show('draw', { duration: 600 })
			line13.show('draw', { duration: 600 })
			line14.show('draw', { duration: 600 })
		}, 1200)

		setTimeout(function () {
			line8.show('draw', { duration: 600 })
			line11.show('draw', { duration: 600 })
			line15.show('draw', { duration: 600 })
		}, 1500)

		setTimeout(function () {
			line9.show('draw', { duration: 600 })
		}, 1800)
	}
})
