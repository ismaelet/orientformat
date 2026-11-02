{% extends main %}

{% block main %}

<form class="form" id="form" method="POST" enctype="multipart/form-data">

	<?= csrf_field() ?>

	<div class="form-head">
		<h1 class="form-title"><?= $title ?? request()->attributes->get('legacy.title') ?></h1>
	</div>

	<div class="form-body">
		{% place form-body %}
	</div>

	<div class="form-footer">
		{% place form-footer %}
	</div>

</form>

{% end main %}