{% block form-body %}

<p class="pad-v-1">Sei sicuro di voler uscire?</p>

{% end form-body %}

{% block form-footer %}

<button type="submit" name="submit" class="button">Logout</button>
<a href="<?= client_url('/') ?>" class="button button--secondary">Indietro</a>

{% end form-footer %}