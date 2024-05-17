{% block main %}

<div class="page-content">

	<!-- Welcome panel -->
	<section class="welcome grid stack-items">

		<div class="welcome-bgr welcome-bgr--no-opacity fill-all bgr-fill" <?= background_image('bgr.jpg') ?>></div>

		<div class="body hidden">

			<h1 class="title txt-f txt-light"></h1>

			<p class="txt-wht">
			</p>

		</div>

	</section>

	<!-- Form -->
	<form method="POST" autocomplete="off" class="form">

		<div class="form-head">
			<h2 class="title title--register"><?= __('Sign up') ?></h2>
		</div>

		<div class="form-body">
			<?= generate_form($inputs, false, $error) ?>
		</div>

		<div class="form-footer">

			<button type="submit" name="submit" class="pbtn"><?= __('Sign up') ?></button>

			<div id="facebook" class="hidden">
				<button type="button" class="mbtn bgr-c3-full" onClick="fb_login();">
					<span class="soc-icon fb-ico wht"></span>
					<span class="align">Facebook Login</span>
				</button>
			</div>

			<a href="<?= html_link('login') ?>" class="sbtn"><?= __('Back') ?></a>

		</div>

	</form>

</div>

{% end main %}