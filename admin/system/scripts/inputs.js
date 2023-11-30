$(document).ready(function () {
	// clear error messages
	$('.clear-error').keypress(function () {
		$('.inp.err').hide()
	})
	$('.clear-error').click(function () {
		$('.inp.err').hide()
	})

	// no spance inputs
	$('.inp-nospace').keypress(function (e) {
		if (e.which === 32) return false
	})

	/*
	 * Required checkboxes
	 */
	$('.js-required-cbx').on('change', function () {
		let self

		if ($(this).is('input')) {
			self = $(this)
		} else {
			self = $(this).find('input[type="checkbox"]')
		}

		const name = self.attr('name')

		self.parents('.js-cbx-container').find('.js-required-cbx').prop('checked', false)

		if (name) {
			$('[name="' + name + '"]').prop('checked', false)
		}

		self.prop('checked', true)
	})

	// file upload
	$('.replace-img').click(function () {
		this.nextElementSibling.click()
	})

	$('.upload-on-change').on('change', function () {
		const form = this.closest('form')

		form.classList.add('loading')
		form.submit()
	})

	// fancy inputs
	$('.fancy-input .inp').on('input keyup', function () {
		const self = $(this)

		if (self.val()) {
			self.parent().removeClass('not-filled')
		} else {
			self.parent().addClass('not-filled')
		}
	})

	// dependent selector
	$('.sel.affect').each(function () {
		selector_affect($(this))
	})
	$('.sel.affect').on('change', function () {
		selector_affect($(this))
	})

	function selector_affect(selector) {
		const affected = selector.parent().find('.sel[name="' + selector.data('affect') + '"]')
		const field_id = affected.data('id')
		const field_show = affected.data('show')

		affected.attr('disabled', false).empty()

		$.ajax({
			type: 'POST',

			url: affected.data('root') + '/system/modules/ajax/search-selector.php',

			data: { tbl: affected.data('tbl'), filter: affected.data('filter'), filter_val: selector.val(), field_id: field_id, field_show: field_show },

			success: function (data) {
				const options = $.parseJSON(data)

				for (var i = 0; i < options.length; i++) {
					const option = options[i]

					affected.append('<option value="' + option[field_id] + '" selected>' + option[field_show] + '</option>')
				}
			},
		})
	}

	// ajax search
	$('.ajax-search-txt').keyup(async function () {
		// setup
		const self = $(this)
		const search = self.val()
		const parent = self.parents('.ajax-search')
		const parcialEndpoint = parent.data('endpoint')
		const valueField = parent.data('value-field')
		const showField = parent.data('show-field')
		const filter = parent.data('filter')
		const parameters = {
			searchFields: filter,
			search: search,
			scope: valueField + ',' + showField,
			orderBy: showField,
			orderDirection: 'ASC',
			limit: 10,
		}

		parent.find('.ajax-search-box').html('')

		response = await API(parcialEndpoint, 'GET', parameters)

		if (response['error']) {
			console.log('API Error: ' + response['error'])
		} else if (response) {
			let results = response

			const count = Object.keys(results).length

			// if there are results
			if (count) {
				parent.find('.ajax-search-box').html('')

				// generate the rows with the results
				for (const [key, value] of Object.entries(results)) {
					parent.find('.ajax-search-box').append('<p class="ajax-search-item" data-id="' + value[valueField] + '" data-text="' + value[showField] + '">' + value[showField] + '</p>')
				}

				parent.find('.ajax-search-ddown').show()

				// if there aren't results
			} else {
				parent.find('.ajax-search-ddown').hide()
			}
		}
	})

	$('.ajax-search').on('click', '.ajax-search-item', function () {
		var self = $(this)
		var parent = self.parents('.ajax-search')

		parent.find('.ajax-search-id').val(self.data('id'))
		parent.find('.ajax-search-txt').val(self.data('text'))

		parent.find('.ajax-search-ddown').hide()
	})

	function hide_ajax_searcher(searcher) {
		const count = searcher.find('.ajax-search-item').length

		searcher.find('.ajax-search-ddown').hide()

		if (count == 1) {
			searcher.find('.ajax-search-id').val(searcher.find('.ajax-search-item').data('id'))
			searcher.find('.ajax-search-txt').val(searcher.find('.ajax-search-item').data('text'))
		}
	}

	$(document).click(function () {
		$('.ajax-search').each(function () {
			hide_ajax_searcher($(this))
		})
	})

	$('.ajax-search').click(function (event) {
		event.stopPropagation()
	})
})
