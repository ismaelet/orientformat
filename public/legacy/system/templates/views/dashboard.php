{% extends blank %}

{% block body %}

<main>
	<aside class="dashboard__navigation js-dashboard-navigation">
		<div class="dashboard__navigation-wrapper">

			<div class="dashboard__navigation-header">
				<!-- logo -->
				<div class="dashboard__logo" data-content="<?= schoolClass()->name ?>"></div>
			</div>

			<!-- Admin sections -->
			<nav class="dashboard__navigation-body">

				<!-- Navigation -->
				<?php foreach ($dashboardNavigation as $category) { ?>

					<!-- Menu category -->
					<ul class="dashboard-category">

						<!-- Title box -->
						<label class="dashboard-category__header">
							<a <?= !empty($category['url']) ? 'href="' . $category['url'] . '"' : '' ?>>
								<input type="radio" name="dashboard-category" <?= $category['checked'] ? 'checked' : null ?>>

								<?= embed_icon(APP_ICONS_DIR . 'dashboards/' . $category['slug']) ?>

								<p class="dashboard-category__label"><?= $category['title'] ?></p>
							</a>
						</label>

						<!-- Dropdown -->
						<?php if (!empty($category['links'])) { ?>

							<ul class="dashboard-category__dropdown-wrapper">
								<div class="dashboard-category__dropdown">

									<?php foreach ($category['links'] as $i => $link) { ?>

										<label class="dashboard-category__link">
											<input type="radio" name="dashboard-link" <?= $link['checked'] ? 'checked' : null ?>>

											<a href="<?= $link['url'] ?>">
												<?= $link['title'] ?>
											</a>
										</label>

									<?php } ?>
								</div>
							</ul>

						<?php } ?>

					</ul>

				<?php } ?>

			</nav>
		</div>
	</aside>

	<section class="dashboard__body js-dashboard-content">
		{% place content %}
	</section>
</main>

{% end body %}