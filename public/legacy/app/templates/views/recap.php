{% extends main %}

{% block main %}

<div class="page-header grid-flow center-content stack-content contrasting-background">
	<div class="page-header__background fill-all background-fill" <?= background_image($coverImage) ?>></div>
	<div class="page-header__overlay gradient-overlay fill-all background-fill"></div>

	<div class="page-header__content grid-flow center-content main-wrap" data-spacing="700">
		<h1 class="page-header__title title"><?= $section->name ?></h1>

		<?php if ($area->id <> 4) { ?>

			<a class="button" href="<?= client_url('/student-read?id=' . $section->mainSection->id) ?>">
				<?= embed_icon('read') ?>
				Saperne di più
			</a>

		<?php } ?>

	</div>
</div>

<div id="content" class="pad-t-5 pad-b-5">

	<div class="main-wrap">

		<!-- Subtitle and description -->
		<div class="grid-flow center-content" data-spacing="400">
			<h2 class="subsection-title">Riepilogo della sezione</h2>
			<p class="subsection-subtitle">Qui puoi controllare i tuoi progressi in questa sezione, ricominciare una attività o rivisitarla.</p>
			<a class="button button--secondary button--auto-width mar-t-1" href="<?= client_url($backUrl) ?>">Scegli un'altra sezione</a>
		</div>

		<!-- Tests -->
		<div class="tests mar-t-5 grid-flow" data-columns="25rem" data-spacing="700">

			<?php foreach ($tests as $key => $testM) {
				$obj = $testM['obj'];
			?>

				<div class="pos-rel load--fade-in js-load" data-direction="bottom" data-delay="<?= $key % 3 ?>">
					<form id="test<?= $obj->id ?>" class="test bgr-wht grid-flow" method="POST">
						<input type="hidden" name="testId" value="<?= $obj->id ?>">

						<div class="test-img">
							<?= embed_icon($testM['img']) ?>
						</div>

						<div class="test-data">

							<div class="test-texts">

								<h1 class="test-title txt-upp txt-12rem txt-bold"><?= $obj->title ?></h1>

								<?php if (!$obj->static) { ?>

									<p class="test-stitle txt-upp mar-t-05 <?= !$obj->completed ? 'active' : ''; ?>"><?= $testM['desc'] ?></p>

								<?php } ?>

								<p class="mar-t-1"><?= $obj->shortDescription ?></p>
							</div>

							<div class="test-btn-box">

								<?php if (($obj->template != 'survey' || !$obj->completed) && $obj->type != 3) { ?>

									<p class="test-btn fc-tertiary">
										<a href="<?= $obj->clientUrl ?>">Visualizza</a>
									</p>

								<?php } ?>

								<?php if ($obj->template == 'survey' && $obj->completed) { ?>

									<p class="test-btn fc-confirmation" onclick="$(this).next().click()">Scarica risposte</p>
									<button type="submit" class="hidden" name="download"></button>

								<?php } ?>

								<?php if ($obj->completed && !$obj->static) { ?>

									<p class="test-btn fc-warning" onclick="$(this).next().click()">Ricomincia</p>

									<button type="submit" name="reset" class="hidden" onclick="return confirm('Sei sicuro/a di voler ricominciare l\'attività?')"></button>

								<?php } ?>

							</div>
						</div>
					</form>
				</div>

			<?php } ?>

		</div>
	</div>
</div>

{% end main %}