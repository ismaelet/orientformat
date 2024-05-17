{% block content %}

<div id="preload" <?= background_image('bgr.jpg') ?>></div>

<div class="main-wrap pad-v-5 fa-center grid">
	<div id="content">

		<?= title() ?>

		<div id="start" class="button mar-t-4">Comincia</div>
	</div>
</div>

<div id="backgrounds" class="bgr">
	<div id="bgr" class="bgr" <?= background_image('bgr.jpg') ?>></div>
	<div id="blank" class="bgr bgr-1"></div>
	<h1 id="countdown" class="txt-wht fw-bold">60</h1>

	<h1 id="interlude" class="place-cenY wid-100 fa-center txt-2rem  txt-wht pad-h-2">Bravo! Ora concentrati, ad occhi chiusi, sulla bandierina per un minuto.</h1>

	<div id="end" class="place-cenY wid-100 fa-center pad-h-2">
		<h1 class="txt-2rem  txt-wht">Ottimo!<br>Clicca qui sotto per continuare.</h1>
		<button type="submit" name="submit" class="button mar-t-2">Procedi</button>
	</div>
</div>

{% end content %}