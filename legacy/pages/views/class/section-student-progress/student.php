{% block content %}

<!-- Content -->
<section class="pad-b-5">

	<!-- Title -->
	<div class="title-box mar-t-3 fa-center">
		<h1 class="title txt-25rem txt-sbold"><span class="txt-15rem">Progresso di</span><br><?= $student->fullName ?></h1>
		<p class="stitle txt-1rem mar-t-1">Qui puoi monitorare il progresso dello studente/studentessa diviso per attività</p>
	</div>

	<div class="areas mar-t-5">

		<?php foreach ($areas as $area) { ?>

			<div class="area">

				<h3 class="area-title"><?= $area['name'] ?></h3>

				<div class="sections" style="--count: <?= count($area['sections']) ?>">

					<?php foreach ($area['sections'] as $key => $legacySection) {

						$result = Student\SectionTestResult::getResult(\Illuminate\Support\Facades\Auth::id(), $legacySection['id']) ?: ($legacySection['defaultResult'] ?? false);
					?>

						<div class="dashboard-panel load slide-bottom" style="--i: <?= $key + 1 ?>">
							<div class="dashboard-panel-body">
								<div class="dashboard-panel-icon icon-box load slide-bottom ld-2">
									<?= embed_icon('/pages/assets/area/section' . $legacySection['id']) ?>
								</div>
								<h3 class="dashboard-panel-title"><?= $legacySection['name'] ?></h3>
							</div>

							<?php if ($result) { ?>
								<h3 class="dashboard-panel_result">
									<span class="inlb"><?= $legacySection['resultName'] ?? 'Risultato' ?>:</span><br>
									<span class="dashboard-panel_value inlb fw-bold"><?= $result ?></span>
								</h3>
							<?php } ?>

							<div class="dashboard-panel-footer">
								<?php if (isset($legacySection['actions'])) {
									foreach ($legacySection['actions'] as $btnTitle => $btnUrl) { ?>

										<p class="dashboard-home-more">
											<a href="<?= $btnUrl ?>"><?= $btnTitle ?></a>
										</p>

									<?php }
								} else { ?>

									<p class="dashboard-home-more">
										<a href="<?= $legacySection['slug'] ?>">Vedi i risultati</a>
									</p>

								<?php } ?>
							</div>
						</div>

						<?php if ($area['name'] != 'Questionari') { ?>
							<div class="section-info load slide-bottom ld-1">
								<p>Id exercitation deserunt aliqua ad nulla eu velit voluptate commodo laborum proident. Eu dolore cillum id cupidatat minim deserunt qui do duis Lorem reprehenderit. Ullamco est laboris sint anim deserunt ipsum aliquip. Dolore qui in tempor exercitation ipsum veniam ullamco sit amet aliqua do.Eu dolore cupidatat nulla laborum labore. Officia non ex cupidatat est veniam magna est quis deserunt proident consectetur exercitation nostrud. Ipsum excepteur minim laboris laboris quis anim eu sint mollit laboris nulla exercitation cillum. Esse excepteur excepteur sint fugiat qui veniam ad proident magna cupidatat id ullamco ex.</p>
							</div>
						<?php } ?>

					<?php } ?>

				</div>

			</div>

		<?php } ?>

	</div>

</section>

{% end content %}