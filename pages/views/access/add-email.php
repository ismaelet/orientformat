{% block form-body %}

<p>Per favore, inserisci il tuo indirizzo e-mail. Se dovessi dimenticarti i tuoi dati di acesso, useremo questo indirizzo per permetterti di recuperarli.</p>

<?php generate_form($inputs, false, $error) ?>

{% end form-body %}

{% block form-footer %}

<button type="submit" class="button" name="submit">Salva</button>

{% end form-footer %}