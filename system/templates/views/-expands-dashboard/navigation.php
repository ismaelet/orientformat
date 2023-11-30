<?php

if (schoolClass()->isHighSchool) {
	unset($dashboardNavigation[1]['links'][2]);
}

?>

<section class="dashboard-navigation contrasting-background">
	<div class="floating">
		<div class="menu-wrapper">
			<div class="categories">

				<?php if ($dashboardConfig['logo']) { ?>

					<!-- logo -->
					<a class="header" href="<?= client_url('/') ?>">
						<div class="logo icon bgr-wht" <?= img_svg(LOGO_DIR . 'logo.svg') ?>></div>
						<h1 class="title txt-low"><?= sysData('name') ?></h1>
					</a>

				<?php } ?>

				<?php if ($dashboardConfig['return-link']) { ?>

					<!-- Return link -->
					<a href="<?= client_url('/teacher') ?>" class="dashboard-return">
						<h1 class="txt-cen txt-2rem txt-sbold pad-h-1 mar-t-2"><span class="desktop-text">Classe </span><?= schoolClass()->name ?></h1>
						<h3 class="dashboard-return-title flex-line">
							<div class="text-icon" <?= icon_svg('back') ?>></div>
							<span class="desktop-text">Torna all'account</span>
						</h3>
					</a>

				<?php } ?>

				<!-- Admin sections -->
				<div class="group">

					<!-- Home link -->
					<div class="category <?= !$currentPath ? 'active current-category' : '' ?>">
						<a href="<?= client_url('/' . $dashboardConfig['path']) ?>" class="title-box grid">
							<div class="highlight"></div>
							<div class="icon-box">
								<?= icon_embed('home') ?>
							</div>
							<p class="title txt-line"><?= __('Riepilogo') ?></p>
						</a>
					</div>

					<!-- Navigation -->
					<?php foreach ($dashboardNavigation as $category) { ?>

						<!-- Menu category -->
						<div class="category <?= $category['checked'] ? 'active current-category' : '' ?>">

							<!-- Title box -->
							<div class="title-box grid">
								<div class="highlight"></div>
								<div class="icon-box">
									<?= icon_embed(APP_ICONS_DIR . 'dashboards/' . $category['slug']) ?>
								</div>
								<p class="title txt-line"><?= $category['title'] ?></p>
							</div>

							<!-- Dropdown -->
							<?php if (!empty($category['links'])) { ?>

								<div class="ddown" style="--count: <?= count($category['links']) ?>">

									<?php foreach ($category['links'] as $i => $link) { ?>

										<a href="<?= $link['url'] ?>" class="link-box <?= $link['checked'] ? 'active' : '' ?>">
											<div class="square square-<?= $i % 5 + 1 ?>"></div>
											<p class="link txt-line">
												<?= $link['title'] ?>
											</p>
										</a>

									<?php } ?>

								</div>

							<?php } ?>

						</div>

					<?php } ?>

				</div>
			</div>
		</div>

		<!-- Mobile open menu icon -->
		<div id="open-menu" class="icon-box">
			<?= icon_embed('navigation/arrow1-right') ?>
		</div>
	</div>
</section>