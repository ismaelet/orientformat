{% block main %}

<!-- Body -->
<div class="page-content px-8 text-center">
	<img class="logo" src="<?= file_url(__LOGO__ . 'logo.png') ?>" alt="">
	<h1 class="txt-bold txt-upp"><?= __('Offline Website') ?></h1>
	<p class="mwid-600 txt-12rem">
		<?= __("We are updating our website. We'll be back online as soon as possible.") ?>
	</p>
</div>

<!-- Login button -->
<form class="login flex ha-cen pad-b-1" method="POST">
	<button type="submit" class="login-btn btn-with-icons clickable" name="submit">
		<span class="text-icon small bgr-c1" <?= icon_svg('key') ?>></span>
		<span class="login-text br-b-1 br-c1 txt-c1 txt-09rem"><?= __('Admin login') ?></span>
	</button>
</form>

{% end main %}