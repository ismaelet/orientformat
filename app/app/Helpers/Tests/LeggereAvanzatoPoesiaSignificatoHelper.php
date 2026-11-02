<?php

namespace App\Helpers\Tests;

class LeggereAvanzatoPoesiaSignificatoHelper extends ImparareBaleneHelper
{
    protected function text(): string
    {
        return '
		Spesso, per divertirsi, gli uomini d’equipaggio<br>
		catturano degli albatri, grandi uccelli di mare,<br>
		che {! seguono, indolenti compagni di viaggio,<br>
		la nave :: marker0 !} che scivola sugli abissi amari.<br><br>

		Appena li hanno deposti sul ponte,<br>
		questi {! re dell’azzurro :: marker0 !}, {! maldestri e vergognosi,<br>
		lasciano cadere miseramente le grandi ali bianche :: marker1 !}<br>
		come remi inerti trascinati ai loro fianchi.<br><br>

		Quel {! viaggiatore alato :: marker0 !}, com’è {! sgraziato e remissivo! :: marker1 !}<br>
		Lui, poco fa {! così bello :: marker0 !}, com’è {! comico e brutto! :: marker1 !}<br>
		Uno gli stuzzica il becco con la pipa,<br>
		un altro imita, zoppicando, {! l’infermo :: marker1 !} che volava!<br><br>

		Il Poeta è come lui, {! principe delle nuvole :: marker0 !}<br>
		che {! sfida la tempesta :: marker0 !} e {! se la ride dell’arciere :: marker0 !};<br>
		fra le grida di scherno esule in terra,<br>
		le sue ali di gigante non gli permettono di camminare.';
    }

    protected function markerLabels(): array
    {
        return [
            'Albatro in volo',
            'Albatro sul ponte',
        ];
    }
}
