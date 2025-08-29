@php

	use Legacy\UserSystem\Student;

	$userId = auth()->id();
	$user = auth()->user();
	$userGroupId = $user ? $user->groupId : 0;

	$header = [];

	$h_comp = [];

	$h_comp['logo'] = true;
	$h_comp['name-bar'] = false;
	$h_comp['srch-bar'] = false;
	$h_comp['lang-bar'] = false;
	$h_comp['login'] = true;
	$h_comp['force-mob'] = false;
	$h_comp['privacy'] = true;
	$h_comp['wishlist'] = false;

	$header['color'] = 'light';
	$header['floating'] = false;

	// name
	$h_name = '<span class="txt-c1">O</span>RIENTAMENTO';
	$h_name_mob = '<span class="txt-c1">Ori.</span>For.';

	// links
	$h_links = [];

	$raw_links = [
	    [
	        'title' => 'Gestisci classe',
	        'loc' => 'teacher',
	        'url' => client_url('/teacher'),
	        'logged' => true,
	        'teacher' => true,
	        'mobile' => true,
	    ],
	    [
	        'title' => 'Activities',
	        'loc' => 'activities',
	        'url' => route('activities.grades.index'),
	        'logged' => true,
	        'student' => true,
	    ],
	    [
	        'title' => 'Simulazione',
	        'loc' => '',
	        'url' => client_url('/teacher/simulation'),
	        'teacher' => true,
	        'drop' => 'simulation',
	    ],
	    [
	        'title' => 'Saperne di più',
	        'loc' => '',
	        'url' => client_url('/teacher/know-more'),
	        'teacher' => true,
	    ],
	    [
	        'title' => 'Contattaci',
	        'loc' => '',
	        'url' => client_url('/teacher/support/open-ticket'),
	        'teacher' => true,
	        'administrator' => true,
	    ],
	    [
	        'title' => 'Support',
	        'loc' => 'help',
	        'url' => client_url('/help'),
	    ],
	    [
	        'title' => 'Login',
	        'loc' => 'login',
	        'url' => client_url('/login'),
	        'logged' => false,
	        'mobile' => true,
	    ],
	    [
	        'title' => 'Logout',
	        'loc' => 'login',
	        'url' => client_url('/logout'),
	        'logged' => true,
	        'mobile' => true,
	    ],
	    [
	        'title' => 'Logout',
	        'loc' => 'login',
	        'url' => client_url('/logout'),
	        'logged' => true,
	        'mobile' => false,
	    ],
	];

	foreach ($raw_links as $link) {
	    $valid = true;

	    // check logged filter
	    if (isset($link['logged'])) {
	        if ($link['logged'] && !$userId) {
	            $valid = false;
	        } elseif (!$link['logged'] && $userId) {
	            $valid = false;
	        }
	    }

	    // check student filter
	    if (isset($link['student']) && $userGroupId != 0) {
	        $valid = false;
	    }

	    // check teacher filter
	    if (isset($link['teacher']) && ($userGroupId != 1 || (is_administrator() && !isset($link['administrator'])))) {
	        $valid = false;
	    }

	    // check manager filter
	    if (isset($link['manager']) && !manager()) {
	        $valid = false;
	    }

	    if ($valid) {
	        $h_links[] = $link;
	    }
	}

	// login bar
	$h_log_out = ['Login', client_url('/login')];
	$h_log_in = false;

	if ($userId) {
	    if ($userGroupId == 2) {
	        $h_log_in = ['Amministrazione', client_url('/management')];
	    } elseif ($userGroupId == 1) {
	        $h_log_in = ['Gestione Classi', client_url('/teacher')];
	    } else {
	        $h_log_in = ['Logout', client_url('/logout')];
	    }
	}

	// survey end
	$header['survey-end'] = false;

	if (
	    auth()->check() &&
	    !$userGroupId &&
	    !\App\Legacy\LegacyDB::exists('review_results WHERE studentId = ? AND reviewId = 3', [$userId])
	) {
	    $h_grade = new Student($userId)->schoolClass;
	    $header['survey-end'] = $h_grade && $h_grade->ended;
	}

	$h_drop = [
	    'simulation' => [
	        ['Scuola secondaria di primo grado', '/teacher/simulation?type=middle-school'],
	        ['Istituti Tecnici, Professionali e Licei', '/teacher/simulation?type=high-school'],
	        ['Istruzione e Formazione Professionale', '/teacher/simulation?type=professional-school'],
	    ],
	];

@endphp

@pushOnce('styles')
	<style>
		/*Containers*/
		header {
			position: relative;
			top: 0;
			left: 0;
			z-index: 100;
			box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
			width: 100%;
			height: 80px;
		}

		#h-pan {
			width: 100%;
			padding-inline: 3rem;
			top: 0;
			left: 0;
			background-color: #fff;
		}

		.page-container:has(header.floating) {
			grid-template-rows: 1fr;
		}

		.floating #h-pan {
			background-color: transparent;
		}

		#h-pan.fixed,
		#h-pan.h-open {
			background-color: #fff;
			position: fixed !important;
		}

		#h-pan.h-open #h-bgr,
		#h-pan.fixed #h-bgr {
			opacity: 1 !important;
		}

		.h-bars {
			display: grid;
			grid-template-columns: max-content 0 1fr;
			align-items: center;
			position: relative;
		}

		.h-nav-bar:nth-child(3) {
			display: flex;
			justify-content: right;
			align-items: center;
			gap: 1rem;
		}

		/* Logo */
		#h-logo {
			background-size: contain;
			background-position: left;
			width: 10rem;
			height: 5rem;
		}

		/* Name and searchbar */
		.h-name {
			font-size: 22px;
			letter-spacing: 0.1em;
			transition: color 0.4s;
		}

		#h-srch {
			margin-left: -1rem;
			font-size: 0;
			white-space: nowrap;
			overflow: hidden;
		}

		#h-srch .h-name-box {
			max-width: 100%;
			overflow: hidden;
			transition: max-width 0.1s 0.3s;
		}

		#h-srch-ico-box {
			display: inline-block;
			border-width: 1px;
			border-style: solid;
			border-color: #ddd;
			width: 50px;
			height: 50px;
			transition: border 0.2s;
			cursor: pointer;
		}

		#h-srch-ico {
			background-size: 20px;
			background-position: center;
			width: 100%;
			height: 100%;
		}

		#h-srch-ico-box .bgr {
			opacity: 0;
			width: calc(100% + 2px);
			height: calc(100% + 2px);
			top: -1px;
			left: -1px;
			transition: opacity 0.4s;
		}

		#h-srch-inp-box {
			display: inline-block;
			width: 0;
			overflow: hidden;
			transition: width 0.4s;
			vertical-align: middle;
		}

		#h-srch-inp {
			background-color: #f2f3f5;
			border: 1px solid #e6e7eb;
			border-width: 1px 1px 1px 0;
			width: 100%;
			height: 50px;
			padding: 0 15px;
			font-family: var(--font-text);
		}

		#h-srch-cbx:not(:checked)~#h-srch-ico-box {
			border-color: transparent !important;
		}

		#h-srch-cbx:checked~#h-srch-ico-box .bgr {
			opacity: 1;
		}

		#h-srch-cbx:checked~#h-srch-inp-box {
			width: 300px;
		}

		#h-srch-cbx:checked~.h-name-box {
			max-width: 0;
			transition: max-width 0.1s;
		}

		/* Desktop links */
		.h-nav-box {
			align-items: center;
			gap: 2rem;
		}

		.h-link {
			vertical-align: middle;
		}

		.h-link-txt {
			font-weight: 600;
			line-height: 80px;
			transition: color 0.2s, border-color 0.2s;
		}

		.h-link-txt:hover,
		.h-link-txt.active {
			border-color: var(--color-primary-400);
			color: var(--color-primary-400);
		}

		.h-link-txt a {
			display: block;
		}

		.h-link-txt--button {
			padding-block: 1em;
			padding-inline: 2.5em;
			border: var(--border-width) solid;
			border-radius: 100vw;
			line-height: unset;
		}

		.h-drop-ico {
			font-size: 0.8em;
			vertical-align: top;
		}

		/* Desktop dropdown menu */
		.h-drop {
			background-color: var(--color-primary-400);
			width: 300px;
			max-height: 0;
			position: absolute;
			top: 100%;
			left: calc(50% - 115px);
			overflow: hidden;
			transition: max-height 0.2s ease-out;
			z-index: 1;
		}

		.h-link:hover .h-drop,
		#nav_prof:hover .h-drop {
			max-height: 300px;
			transition: max-height 0.4s ease-in;
		}

		.h-drop-link {
			display: block;
			line-height: 1.5;
			text-align: left;
			transition: background 0.2s, color 0.2s;
		}

		.h-drop-link a {
			display: block;
			padding: 1em 1em;
		}

		/* Wishlist & Cart */
		#h-cart {
			background-position: center;
			background-size: contain;
			width: 20px;
			height: 20px;
			padding: 0;
			margin: 0 1rem;
		}

		#h-cart-num {
			background: #e00003;
			border-radius: 100%;
			width: 14px;
			position: absolute;
			bottom: 0.9rem;
			left: 0.9rem;
			color: #fff;
			font-size: 0.8rem;
			line-height: 14px;
			text-align: center;
		}

		#h-wish {
			background-position: center;
			background-size: contain;
			width: 20px;
			height: 20px;
			padding: 0;
			margin: 0 1rem;
		}

		/* Login & profile */
		#h-user-ico {
			display: block;
			background-color: #ddd;
			background-position: center;
			background-size: cover;
			border: 2px solid #8b8b8b;
			width: 40px;
			height: 40px;
			transition: border 0.1s;
		}

		.h-log-txt {
			margin-left: 2rem;
			display: inline-block;
			transition: color 0.4s, background 0.4s, border 0.4s;
		}

		.h-log-txt.main {
			padding: 0 1.7rem;
			letter-spacing: 0.2em;
			line-height: calc(3rem - 2px);
		}

		/* Mobile menu icon */
		#h-icoM-box {
			position: relative;
			width: 3rem;
			height: 4rem;
			cursor: pointer;
		}

		.h-icoM-line {
			width: 25px;
			height: 3px;
			position: absolute;
			top: calc(50% - 2px);
			right: 0;
			transition: transform 0.4s;
		}

		.h-icoM-rot {
			width: 100%;
			height: 100%;
			transform: rotate(0deg);
			transition: transform 0.4s;
		}

		#h-icoM-line1 {
			transform: translateY(-10px);
			transition: transform 0.4s 0.4s;
		}

		#h-icoM-line3 {
			transform: translateY(10px);
			transition: transform 0.4s 0.4s;
		}

		#h-cbxM:checked+#h-icoM-box #h-icoM-line1,
		#h-cbxM:checked+#h-icoM-box #h-icoM-line3 {
			transform: translateY(0);
			transition: transform 0.4s;
		}

		#h-cbxM:checked+#h-icoM-box #h-icoM-line1 .h-icoM-rot {
			transform: rotate(45deg);
			transition: transform 0.4s 0.4s;
		}

		#h-cbxM:checked+#h-icoM-box #h-icoM-line3 .h-icoM-rot {
			transform: rotate(-45deg);
			transition: transform 0.4s 0.4s;
		}

		#h-icoM-line2 {
			opacity: 1;
			transition: opacity 0.1s 0.4s, transform 0.2s 0.4s;
		}

		#h-cbxM:checked+#h-icoM-box #h-icoM-line2 {
			opacity: 0;
			transform: translateX(-4rem);
			transition: opacity 0.1s 0.1s, transform 0.2s;
		}

		/* Mobile menu */
		#h-navM {
			width: 100%;
			height: 100%;
			overflow: hidden;
			overflow-y: auto;
			position: fixed;
			top: 65px;
			left: -100%;
			z-index: 1;
			transition: left 0.4s;
		}

		#h-cbxM:checked~#h-navM {
			left: 0;
		}

		#h-contM {
			position: relative;
			padding: 2rem 2rem 0 2rem;
		}

		.h-linkM-txt {
			opacity: 0;
			border-bottom: 1px dashed #ddd;
			padding-left: 20px;
			transform: translateX(-4rem);
			font-size: 1.1rem;
			letter-spacing: 0.1em;
			line-height: 6;
			cursor: pointer;
			transition: opacity 0.4s 0.5s, transform 0.4s 0.4s, color 0.5s;
		}

		#h-cbxM:checked~#h-navM .h-linkM-txt {
			opacity: 1;
			transform: translateX(0);
		}

		.h-linkM-bgr {
			opacity: 0;
			transition: opacity 0.4s;
			z-index: -1;
		}

		.h-lineM {
			height: 1px;
			margin: 1rem 0;
		}

		/* Mobile dropdown */
		.h-dropM-cbx:checked+a .h-linkM-txt {
			color: #fff !important;
		}

		.h-dropM-cbx:checked+a .h-linkM-bgr {
			opacity: 1;
		}

		.h-dropM-link {
			opacity: 0;
			display: block;
			border-width: 0;
			border-style: solid;
			height: 0;
			padding-left: 20px;
			font-size: 0.9rem;
			letter-spacing: 0.1em;
			line-height: 4rem;
			overflow: hidden;
			transition: opacity 0.4s, border 0.4s, height 0.4s, background 0.4s, color 0.2s;
		}

		.h-dropM-cbx:checked~.h-dropM .h-dropM-link {
			opacity: 1;
			border-width: 0 0 1px 0;
			height: 4rem;
		}

		.h-dropM-link a {
			display: block;
		}

		/*Open version*/
		header.floating {
			box-shadow: none;
			position: absolute;
		}

		header.floating #h-pan:not(.fixed) #h-bgr {
			opacity: 0;
		}

		/* Survey prompt */
		.review-prompt {
			position: fixed;
			top: 6rem;
			left: 50%;
			translate: -50% 0;
			z-index: 100;
			width: min(100%, 30rem);
			max-width: calc(100% - 4rem);
			padding: 0.5em 1em;
			background-color: #ff7679;
			border: 1px solid #d90a0e;
			border-radius: var(--border-radius-400);
			text-align: center;
		}

		.review-prompt span {
			font-weight: 800;
			color: var(--color-bad-500);
		}

		/* Responsive */
		@media (max-width: 1024px) {
			#h-pan {
				padding-left: 3rem;
				padding-right: 3rem;
			}

			#h-logo {
				height: 4.5rem;
			}
		}

		@media (max-width: 480px) {
			#h-pan {
				padding-left: 2rem;
				padding-right: 2rem;
			}

			.h-name {
				font-size: 1.4rem;
				letter-spacing: 0;
			}

			#h-contM {
				padding-left: 1rem;
				padding-right: 1rem;
			}

			#h-srch-cbx:checked~#h-srch-inp-box {
				width: calc(100vw - 14rem);
			}
		}

		/* Light version */
		.light .h-name,
		.light .h-link-txt:not(.active):not(:hover),
		.light .h-linkM-txt {
			color: #333;
		}

		.light .h-dropM-link {
			color: #666;
			border-color: #ddd;
		}

		.light .h-dropM-link:hover {
			color: #fff;
		}

		.light .h-icoM-rot {
			background-color: #333;
		}

		.light #h-bgr,
		.light #h-navM-bgr {
			background-color: #fff;
		}

		.light #h-navM {
			background-color: #fff;
		}

		/* Dark version */
		.dark .h-name,
		.dark .h-link-txt:not(.active):not(:hover),
		.dark .h-log-txt,
		.dark .h-linkM-txt {
			color: #eee;
		}

		.dark .h-dropM-link {
			color: #ccc;
			border-color: #2f5072;
		}

		.dark .h-icoM-rot {
			background-color: #eee;
		}

		.language-dropdown {
			opacity: 0;
			visibility: hidden;
			transition: opacity 0.4s, visibility 0s 0.4s;
		}

		input:checked+.language-dropdown {
			opacity: 1;
			visibility: visible;
			transition: opacity 0.4s;
		}
	</style>
@endPushOnce

@pushOnce('scripts')
	<script
		src="https://code.jquery.com/jquery-3.7.1.min.js"
		integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
		crossorigin="anonymous"
	></script>
	<script defer>
		$(document).ready(function() {

			fix_height();

			$(window).resize(function() {
				fix_height();
			})

			function fix_height() {
				var head_height = $('#h-pan').outerHeight();
				$('header').css('height', head_height + 'px');
				$('#h-navM').css({
					'top': head_height + 'px',
					'height': 'calc(100% - ' + head_height + 'px)'
				});
			}

			//survey prompot
			$('#survey-prompt .icon').click(function() {
				$('#survey-prompt').hide();
			});

		});
	</script>
@endPushOnce

<header class="<?= $header['color'] ?> <?= $header['floating'] ? 'floating' : '' ?>">

	<div id="h-pan">

		<div
			id="h-bgr"
			class="bgr bg-secondary"
		></div>

		<div class="h-bars">
			<!-- Left bar -->
			<section
				id="h-nav-lef"
				class="h-nav-bar"
			>

				<!-- Logo -->
				<a
					href="<?= config('custom.contacts.web.url') ?>"
					id="h-logo"
					class="flex items-center"
				>
					<img
						src="<?= Vite::image('logo/logo_blue.png') ?>"
						alt=""
					>
				</a>

			</section>

			<!-- Central bar -->
			<section
				id="h-nav-cen"
				class="h-nav-bar"
			></section>

			<!-- Right bar -->
			<section
				id="h-nav-rig"
				class="h-nav-bar"
			>

				<!-- Links -->
				<?php if (!$h_comp['force-mob']) { ?>

				<div class="h-nav-box va-cen txt-wht hidden lg:flex">

					<?php foreach ($h_links as $h_link) {
							if (!isset($h_link['mobile']) || !$h_link['mobile']) { ?>

					<div class="h-link relative">
						<p class="h-link-txt">
							<a href="<?= $h_link['url'] ?>">
								{{ __($h_link['title']) }}
								@if (isset($h_link['drop']))
									<span class="h-drop-ico">&#x25BC;</span>
								@endif
							</a>
						</p>

						<?php if (isset($h_link['drop'])) { ?>

						<div class="h-drop bgr-c1">

							<?php foreach ($h_drop[$h_link['drop']] as $h_drop_link) { ?>

							<p class="h-drop-link bgr-wht-h txt-wht txt-blk-h"><a
									href="<?= client_url($h_drop_link[1]) ?>"><?= $h_drop_link[0] ?></a></p>
							<?php } ?>

						</div>

						<?php } ?>

					</div>

					<?php } ?>
					<?php } ?>

				</div>

				<?php } ?>

				<!-- Language bar -->
				<?php if (is_student() || is_teacher()) { ?>
				<div
					class="h-languages relative hidden lg:block"
					x-data="{ open: false }"
					@click.away="open = false"
					@click="open = !open"
				>
					<div class="w-8 cursor-pointer"><?= embed_icon(App::currentLocale()) ?></div>

					<input
						type="checkbox"
						class="hidden"
						:checked="open"
					>

					<div
						class="z-100 shadow-rg language-dropdown bg-background absolute left-1/2 flex -translate-x-1/2 flex-col gap-4 rounded-sm p-3"
					>

						<?php foreach (config('app.locales') as $locale => $language) {
								if ($locale != App::currentLocale()) { ?>

						<a
							href="<?= route('locale.switch', $locale) ?>"
							class="h-language <?= App::currentLocale() == $locale ? 'active' : '' ?>"
						>

							<div class="w-8"><?= embed_icon($locale) ?></div>
						</a>

						<?php }
							} ?>
					</div>
				</div>
				<?php } ?>

				<!-- Login bar -->
				<?php if ($h_comp['login']) { ?>
				<div
					id="h-log-box"
					class="inlb va-cen hidden lg:block"
				>

					<?php if ($userId) { ?>

					<a href="<?= $h_log_in[1] ?>">
						<p class="h-link-txt h-link-txt--button"><?= $h_log_in[0] ?></p>
					</a>

					<?php } else { ?>

					<a href="<?= $h_log_out[1] ?>">
						<p class="h-link-txt h-link-txt--button"><?= $h_log_out[0] ?></p>
					</a>

					<?php } ?>

				</div>
				<?php } ?>



				<!-- Mobile menu -->
				<div
					id="h-mob-pan"
					class="txt-rig block lg:hidden"
				>

					<!-- Mobile icon -->
					<input
						type="checkbox"
						id="h-cbxM"
						class="hidden"
						onclick="$('#h-pan').toggleClass('h-open');"
					>

					<label
						id="h-icoM-box"
						for="h-cbxM"
						class=""
					>
						<div
							id="h-icoM-line1"
							class="h-icoM-line"
						>
							<div class="h-icoM-rot"></div>
						</div>
						<div
							id="h-icoM-line2"
							class="h-icoM-line"
						>
							<div class="h-icoM-rot"></div>
						</div>
						<div
							id="h-icoM-line3"
							class="h-icoM-line"
						>
							<div class="h-icoM-rot"></div>
						</div>
					</label>

					<!-- Mobile box -->
					<div
						id="h-navM"
						class="txt-lef <?php if (!$h_comp['force-mob']) {
						    echo 'mob';
						} ?>"
						onClick="$('#h-cbxM').click();"
					>

						<div
							id="h-navM-bgr"
							class="bgr bg-secondary"
						></div>

						<div id="h-contM">

							<!-- Links -->
							<?php foreach ($h_links as $h_link) {

								$h_valid = true;

								//check logged filter
								if (isset($h_link['logged'])) {
									if ($h_link['logged'] && !$userId) {
										$h_valid = false;
									}
									else if (!$h_link['logged'] && $userId) {$h_valid = false;
									}
								}

								//check mobile filter
								if (isset($h_link['mobile']) && !$h_link['mobile']) {
									$h_valid = false;
								}

								//check seller filter
								if (isset($h_link['seller'])) {

									if ($h_link['seller'] && !$user->is_seller()) $h_valid = false;
									else if (!$h_link['seller'] && $user->is_seller()) $h_valid = false;
								}

								//check cart filter
								if (isset($h_link['cart']) && !$user->cart_count) $h_valid = false;

								if ($h_valid) { ?>

							<label class="h-linkM">

								<input
									type="checkbox"
									class="h-dropM-cbx hidden"
								>

								<a <?php if (!isset($h_link['drop'])) {
								    echo 'href="' . $h_link['url'] . '"';
								} ?>>

									<p class="h-linkM-txt">

										<span class="h-linkM-bgr bgr bgr-c1"></span>

										{{ $h_link['title'] }}
										@if (isset($h_link['drop']))
											echo ' <span class="h-dropM-ico">&#x25BC;</span>';
										@endif
									</p>

								</a>


								<?php if (isset($h_link['drop'])) { ?>

								<div class="h-dropM">

									<?php foreach ($h_drop[$h_link['drop']] as $h_drop_link) { ?>

									<p class="h-dropM-link txt-wht-h bgr-c3-h">
										<a href="<?= client_url($h_drop_link[1]) ?>">
											<?= $h_drop_link[0] ?>
										</a>
									</p>

									<?php } ?>
								</div>

								<?php } ?>
							</label>
							<?php }
							} ?>

							<!-- Language -->
							<?php if (is_student()) { ?>
							<div class="mt-12 flex w-full items-center justify-center gap-8">
								<?php foreach (config('app.locales') as $locale => $language) { ?>

								<a
									href="<?= route('locale.switch', $locale) ?>"
									class="h-language <?= App::currentLocale() == $locale ? 'active' : '' ?>"
								>

									<div class="w-8"><?= embed_icon($locale) ?></div>
								</a>

								<?php } ?>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</header>
