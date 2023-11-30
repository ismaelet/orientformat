{% block main %}

<!-- Body -->
<div class="page__content grid-flow center-content main-wrap" data-spacing="400">
	<img class="logo" src="<?= client_path(LOGO_DIR . 'logo-full') ?>" alt="">
	<h1 class="title"><?= __('Website Offline') ?></h1>
	<p class="section-subtitle">
		<?= __("We are updating our website.<br>We'll be back online as soon as possible.") ?>
	</p>
</div>
<!-- Login button -->
<form class="flex-group center-content" method="POST">
	<button class="login-button button button--empty button--auto-width" type="submit" name="submit">
		<?= icon_embed('key') ?>
		<?= __('Admin login') ?>
	</button>
</form>

{% end main %}