{% block form-body %}

<p class="py-4">Sei sicuro/a di voler uscire?</p>

{% end form-body %}

{% block form-footer %}

<button type="submit" class="button">Logout</button>
<a href="<?= client_url('/') ?>" class="button button--secondary">Indietro</a>

{% end form-footer %}