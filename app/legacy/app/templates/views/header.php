<header class="<?= $header['color'] ?> <?= $header['floating'] ? 'floating' : '' ?>">

	<div id="h-pan">

		<div id="h-bgr" class="bgr bg-secondary"></div>

		<div class="h-bars">
			<!-- Left bar -->
			<section id="h-nav-lef" class="h-nav-bar">

				<?php

				use Illuminate\Support\Facades\App;

				if ($h_comp['logo']) { ?>

					<!-- Logo -->
					<a href="<?= config('custom.contacts.web.url') ?>" id="h-logo">
						<img src="<?= asset('images/logo/logo.png') ?>" alt="">
					</a>

				<?php } ?>

				<?php if ($h_comp['name-bar']) { ?>

					<!-- Name -->
					<div clas="h-name-box" class="inlb">
						<h3 class="h-name txt-upp desk">
							<a href="<?= config('custom.contacts.web.url') ?>"><?= $h_name ?></a>
						</h3>
						<h3 class="h-name txt-upp mob">
							<a href="<?= config('custom.contacts.web.url') ?>"><?= $h_name ?></a>
						</h3>
					</div>

				<?php } ?>

			</section>

			<!-- Central bar -->
			<section id="h-nav-cen" class="h-nav-bar"></section>

			<!-- Right bar -->
			<section id="h-nav-rig" class="h-nav-bar">

				<!-- Links -->
				<?php if (!$h_comp['force-mob']) { ?>

					<div class="h-nav-box desk1024 inlb va-cen txt-wht ">

						<?php foreach ($h_links as $h_link) {
							if (!isset($h_link['mobile']) || !$h_link['mobile']) { ?>

								<div class="h-link relative">
									<p class="h-link-txt <?php if (\App\Legacy\LegacyView::getInstance()->location == $h_link['loc']) echo 'active'; ?>">
										<a href="<?= $h_link['url']; ?>">
											<?= __($h_link['title']);
											if (isset($h_link['drop'])) echo ' <span class="h-drop-ico">&#x25BC;</span>' ?>
										</a>
									</p>

									<?php if (isset($h_link['drop'])) { ?>

										<div class="h-drop bgr-c1">

											<?php foreach ($h_drop[$h_link['drop']] as $h_drop_link) { ?>

												<p class="h-drop-link bgr-wht-h txt-wht txt-blk-h"><a href="<?= client_url($h_drop_link[1]) ?>"><?= $h_drop_link[0]; ?></a></p>
											<?php } ?>

										</div>

									<?php } ?>

								</div>

							<?php } ?>
						<?php } ?>

					</div>

				<?php } ?>

				<!-- Language bar -->
				<div class="h-languages relative hidden lg:block" x-data="{ open: false }" @click.away="open = false" @click="open = !open">
					<div class="w-8 cursor-pointer"><?= embed_icon(App::currentLocale()) ?></div>

					<input type="checkbox" class="hidden" :checked="open">

					<div class="absolute left-1/2 -translate-x-1/2 z-100 bg-background shadow-rg p-4 rounded-sm language-dropdown">

						<?php foreach (config('app.locales') as $locale => $language) { ?>

							<a href="<?= route('locale.switch', $locale) ?>" class="h-language <?= App::currentLocale() == $locale ? 'active' : '' ?>">

								<div class="w-8"><?= embed_icon($locale) ?></div>
							</a>

						<?php } ?>
					</div>
				</div>

				<!-- Login bar -->
				<?php if ($h_comp['login']) { ?>
					<div id="h-log-box" class="inlb va-cen <?= $h_comp['force-mob'] ? 'hide' : 'desk1024'; ?> ">

						<?php if ($userId) { ?>

							<a href="<?= $h_log_in[1]; ?>">
								<p class="h-link-txt h-link-txt--button"><?= $h_log_in[0] ?></p>
							</a>

						<?php } else { ?>

							<a href="<?= $h_log_out[1]; ?>">
								<p class="h-link-txt h-link-txt--button"><?= $h_log_out[0] ?></p>
							</a>

						<?php } ?>

					</div>
				<?php } ?>

				<!-- Mobile menu -->
				<div id="h-mob-pan" class="txt-rig <?php if (!$h_comp['force-mob']) echo 'mob1024'; ?>">

					<!-- Mobile icon -->
					<input type="checkbox" id="h-cbxM" class="hidden" onclick="$('#h-pan').toggleClass('h-open');">

					<label id="h-icoM-box" for="h-cbxM" class="">
						<div id="h-icoM-line1" class="h-icoM-line">
							<div class="h-icoM-rot"></div>
						</div>
						<div id="h-icoM-line2" class="h-icoM-line">
							<div class="h-icoM-rot"></div>
						</div>
						<div id="h-icoM-line3" class="h-icoM-line">
							<div class="h-icoM-rot"></div>
						</div>
					</label>

					<!-- Mobile box -->
					<div id="h-navM" class="txt-lef <?php if (!$h_comp['force-mob']) echo 'mob'; ?>" onClick="$('#h-cbxM').click();">

						<div id="h-navM-bgr" class="bgr bg-secondary"></div>

						<div id="h-contM">

							<!-- Links -->
							<?php foreach ($h_links as $h_link) {

								$h_valid = true;

								//check logged filter
								if (isset($h_link['logged'])) {

									if ($h_link['logged'] && !$userId) $h_valid = false;
									else if (!$h_link['logged'] && $userId) $h_valid = false;
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

										<input type="checkbox" class="h-dropM-cbx hidden">

										<a <?php if (!isset($h_link['drop'])) echo 'href="' . $h_link['url'] . '"'; ?>>

											<p class="h-linkM-txt">

												<span class="h-linkM-bgr bgr bgr-c1"></span>

												<?=
												$h_link['title'];
												if (isset($h_link['drop'])) echo ' <span class="h-dropM-ico">&#x25BC;</span>';
												?>

											</p>

										</a>


										<?php if (isset($h_link['drop'])) { ?>

											<div class="h-dropM">

												<?php foreach ($h_drop[$h_link['drop']] as $h_drop_link) { ?>

													<p class="h-dropM-link txt-wht-h bgr-c3-h">
														<a href="<?= client_url($h_drop_link[1]) ?>">
															<?= $h_drop_link[0]; ?>
														</a>
													</p>

												<?php } ?>
											</div>

										<?php } ?>
									</label>
							<?php }
							} ?>

							<!-- Language -->
							<div class="flex justify-center items-center gap-8 w-full mt-12">
								<?php foreach (config('app.locales') as $locale => $language) { ?>

									<a href="<?= route('locale.switch', $locale) ?>" class="h-language <?= App::currentLocale() == $locale ? 'active' : '' ?>">

										<div class="w-8"><?= embed_icon($locale) ?></div>
									</a>

								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</header>

<?php if ($header['survey-end']) { ?>

	<a class="review-prompt" href="<?= client_url('/review?id=' . (student()->isInMiddleSchool ? 3 : 6)) ?>">
		<p class="">Per favore, completa il questionario finale <span>qui</span>.</p>
	</a>

<?php } ?>