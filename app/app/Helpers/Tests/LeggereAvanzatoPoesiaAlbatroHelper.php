<?php

namespace App\Helpers\Tests;

class LeggereAvanzatoPoesiaAlbatroHelper extends ImparareBaleneHelper
{
    protected function text(): string
    {
        return 'Spesso, {! per divertirsi :: marker1 !}, gli {! uomini d’equipaggio :: marker0 !}<br>
		catturano degli {! albatri :: marker0 !}, {! grandi uccelli di mare :: marker3 !},<br>
		che seguono, {! indolenti compagni di viaggio, :: marker3 !}<br>
		la nave che scivola sugli abissi amari.<br><br>

		Appena li hanno deposti sul ponte,<br>
		questi {! re dell’azzurro :: marker3 !}, maldestri e vergognosi,<br>
		lasciano cadere miseramente le grandi ali bianche<br>
		come remi inerti trascinati ai loro fianchi.<br><br>

		Quel {! viaggiatore alato :: marker3 !}, com’è sgraziato e remissivo!<br>
		Lui, poco fa così bello, com’è comico e brutto!<br>
		Uno {! gli stuzzica il becco con la pipa, :: marker2 !}<br>
		un altro {! imita, zoppicando, :: marker2 !} l’infermo che volava!<br><br>

		{! Il Poeta :: marker0 !} è come lui, {! principe delle nuvole :: marker3 !}<br>
		che sfida la tempesta e se la ride dell’arciere;<br>
		fra le grida di scherno esule in terra,<br>
		le sue ali di {! gigante :: marker3 !} non gli permettono di camminare.';
    }

    protected function markerLabels(): array
    {
        return [
            '<strong>Di chi</strong> si parla',
            '<strong>Perché</strong> i marinai  catturano gli albatri',
            '<strong>In che modo</strong> i marinai deridono gli albatri',
            '<strong>Come</strong> vengono definiti gli albatri',
        ];
    }
}
