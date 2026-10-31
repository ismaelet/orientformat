<section class="menu js-menu">
	<div class="menu__content">

		<div class="">
			<!-- Title -->
			<div class="menu__header" href="<?= config('app.url') ?>">
				<?= $navigationLogo ?>
				<h1 class="menu__title"><?= config('app.name') ?></h1>
			</div>

			<!-- Admin sections -->
			<div class="menu__groups grid js-open-menu" data-spacing="400">
				<!-- <div class="menu__group">
					<div class="menu-item">
						<a class="menu-item__header" href="/" target="_blank">
							<?= embed_icon('link') ?>
							<p class="menu-item__title">Sito pubblico</p>
						</a>
					</div>
				</div> -->

				<span class="menu__divider"></span>

				<div class="menu__group">

					<!-- Home link -->
					<div class="menu-item <?= !$currentSection ? 'active' : '' ?>">
						<a class="menu-item__header" href="<?= client_url('/') ?>">
							<?= embed_icon('home') ?>
							<p class="menu-item__title">Home</p>
						</a>
					</div>

					<!-- Navigation -->
					<?php foreach ($menu['categories'] as $category) { ?>

						<!-- Menu category -->
						<div class="menu-item <?= $category['checked'] ? 'active' : '' ?> js-menu-category">

							<!-- Item header -->
							<div class="menu-item__header js-open-menu-category">
								<?= embed_icon(APP_ICONS_DIR . 'navigation/' . $category['slug']) ?>
								<p class="menu-item__title"><?= $category['name'] ?></p>
							</div>

							<!-- Dropdown -->
							<div class="menu__dropdown">

								<?php foreach ($category['sections'] as $legacySection) { ?>

									<div class="menu-subitem">
										<p class="menu-subitem__title <?= $legacySection['checked'] ? 'active' : '' ?>">
											<a href="<?= $legacySection['url'] ?>"><?= $legacySection['name'] ?></a>
										</p>
									</div>

								<?php } ?>

							</div>
						</div>

					<?php } ?>

					</span>
				</div>

				<span class="menu__divider"></span>

				<div class="menu__group">
					<!-- Logout link -->
					<div class="menu-item">
						<a class="menu-item__header" href="<?= client_url('/logout') ?>">
							<?= embed_icon('logout') ?>
							<p class="menu-item__title">Logout</p>
						</a>
					</div>
				</div>
			</div>

			<!-- Mobile open menu icon -->
			<div class="menu__open js-toggle-menu">
				<?= embed_icon('navigation/arrow1-right') ?>
			</div>
		</div>
	</div>
</section>