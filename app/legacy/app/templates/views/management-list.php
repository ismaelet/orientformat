{% extends main %}

{% block main %}

<!-- Slider -->
<section id="slider">

	<div id="bgr-img" class="bgr" <?= background_image('/pages/assets/management/bgr.png') ?>></div>

</section>

<!-- Content -->
<section id="body" class="main-wrap pb-20">
	
	<!-- Title -->
	<div class="title-box mar-t-4 text-center">
		
		<h1 class="title txt-25rem txt-sbold mb-4"><?= $title ?></h1>
		<a href="<?= $back ? $back[1] : client_url('/management') ?>" class="sbtn back"><?= $back ? $back[0] : 'Torna alla gestione'?></a><br>

	</div>

	<?php if (count($list)) { ?>

		<?php if ($search_bar) { ?>

			<!-- Search bar -->
			<form method="GET" class="search-bar grid">
				
				<div class="icon-box clickable">
					<div class="icon cen bgr-5" <?= icon_svg('search') ?>></div>
				</div>

				<input type="text" class="inp" name="search" value="<?= isset($_GET['search']) ? trim($_GET['search']) : '' ?>" placeholder="Cerca in questa lista" autocomplete="off">

				<button type="submit" class="hidden"></button>

			</form>

		<?php } ?>

		<!-- List -->
		<div id="list" class="panel mar-t-3">
			<div class="list">

				<div class="head">
					
					<?php foreach ($fields as $field) if (isset($field['size'])) { ?>

						<p class="field field-<?= $field['size'] ?>"><?= $field['title'] ?? '' ?></p>

					<?php } ?>

				</div>

				<?php foreach ($list as $key => $entry) { ?>

					<form method="POST" action="#row<?= $key ?>" id="row<?= $key ?>" class="row">

						<!-- Fields -->
						<?php foreach ($fields as $field) {

							$type = $field['type'] ?? 'text';
							$name = $field['name'] ?? false;

							if ($type == 'text') {

								$val = $field['value'] ?? $entry[$name];
								if (isset($field['switch'])) $val = empty($val) ? $field['switch'][1] : $field['switch'][0];

								?>

								<!-- Normal fields -->
								<p class="field"><?= $val ?></p>

							<?php } else if ($type == 'find') {

								$val = \App\Legacy\LegacyDB::find($field['find'][0], $entry[$field['find'][1]]);
								if (isset($field['switch'])) $val = empty($val) ? $field['switch'][1] : $field['switch'][0];
								if (isset($field['parse']) && $field['parse'] == 'int') $val = (int) $val;

								?>

								<!-- Find fields -->
								<p class="field"><?= $val ?></p>

							<?php } else if ($type == 'hidden') { ?>

								<!-- Hidden fields -->
								<input type="hidden" name="<?= $field['name'] ?>" value="<?= $entry[$field['name']] ?>">

							<?php } else if ($type == 'btn') { ?>

								<!-- Buttons -->
								<div class="field btn-box">

									<?php foreach ($actions as $action) { ?>

										<?php if (isset($action['name'])) { ?>

											<button
												type="submit"
												name="<?= $action['name'] ?>"
												class="btn <?= $action['color'] ?? '' ?>"
												<?php if (isset($action['warning'])) { ?>
													onclick="return confirm('<?= $action['warning'] ?>')"
												<?php } ?>
											>

												<?= $action['title'] ?>

											</button>

										<?php } else if ($action['type'] == 'edit') { ?>

											<a href="add?id=<?= $entry[$index] ?>" class="btn c3">Modifica</a>

										<?php } else if ($action['type'] == 'delete') { ?>

											<button type="submit" name="delete" class="btn red" onclick="return confirm('Sei sicuro/a di voler l\'elemento? Una volta eliminato non potrà essere recuperato')">Elimina</button>

										<?php } else if ($action['type'] == 'link') { ?>

											<a href="<?= $action['link'].'?id='.$entry[$index] ?>" class="btn gre"><?= $action['title'] ?></a>

										<?php } ?>

									<?php } ?>

								</div>	

							<?php } ?>

							<!-- Index field -->
							<input type="hidden" name="<?= $index ?>" value="<?= $entry[$index] ?>">

						<?php } ?>		

					</form>

				<?php } ?>
				
			</div>
		</div>

		<!-- Download -->
		<form method="POST" class="text-center">

			<button type="submit" name="download" class="button mar-t-3">
				<span class="text-icon bgr-wht" <?= icon_svg('download') ?>></span>
				<span class="btn-text">Scarica</span>
			</div>

		</form>

	<?php } else { ?>

		<!-- Empty -->
		<div class="empty">
			<p>Non ci sono elementi in questa lista.</p>
		</div>

	<?php } ?>

</section>

{% end main %}