{% block content %}

<div class="main-wrap">
	<!-- Title -->
	<div class="title__wrapper">

		<?= title() ?>
		<?= submit() ?>

	</div>

	<!-- Flower -->
	<section id="flower" class="push-center mar-t-7">
		<div class="pad-b-100 mar-b-7">

			<?php foreach ($results as $key => $result) { ?>

				<!-- Petal -->
				<div id="petal<?= $key ?>" class="petal <?= $key > 4 ? 'skill' : 'thinking' ?>" style="--i: <?= $key ?>; --score: <?= $result['score'] ?>;">
					<div class="body bgr js-load load--fade-in" data-direction="bottom" data-delay="<?= $key ?>">

						<!-- Background color -->
						<div class="color bgr"></div>

						<!-- Filler -->
						<div class="petal__background fill bgr"></div>

						<!-- Score -->
						<div class="score-wrapper cen fa-center wid-100">

							<p class="score txt-15rem font-bold"><?= $result['score'] ?></p>

							<?php if (!isSupervisor()) { ?>

								<?php if ($result['completed']) { ?>

									<p class="reset hide inlb font-bold" onclick="$(this).next().click()">ripeti</p>
									<button type="submit" name="reset-test" value="<?= $result['id'] ?>" class="hidden" onclick="return confirm('Sei sicuro di voler ricominciare l\'attività?')"></button>

								<?php } else { ?>

									<p class="reset hide inlb font-bold">
										<a href="<?= $result['url'] ?>">svolgi</a>
									</p>

							<?php }
							} ?>

						</div>
					</div>

					<!-- Title -->
					<div class="name-box js-load load--fade-in" data-direction="bottom" data-delay="<?= $key + 3 ?>">
						<p class="name fa-center txt-13rem font-bold"><?= $result['title'] ?></p>
					</div>
				</div>

			<?php } ?>

			<div id="center" class="cen bgr-wht round"></div>
		</div>
	</section>
</div>

{% end content %}