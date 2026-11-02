<?php

namespace App\Helpers\Tests;

class ImparareSemplificatoAnalizzareHelper extends ImparareBaleneHelper
{
    protected function text(): string
    {
        return
            "Le madri di quasi tutti i felini, gatti compresi, insegnano ai {! cuccioli :: marker0 !} l'arte della caccia {! con infinita pazienza :: marker4 !}{! e con un addestramento che dura anche diversi mesi :: marker4 !}.<br><br> La madre {! inizia :: marker1 !} portando nei pressi della \"tana\" una preda morta, di cui si ciba in presenza dei cuccioli. {! Successivamente :: marker1 !} porta loro una preda, sempre morta, di cui si potranno {! cibare :: marker3 !}, con cui potranno {! giocare :: marker3 !} e {! allenarsi :: marker3 !} mimando le varie tecniche di presa.<br><br>
La gatta passa poi alla {! fase successiva :: marker1 !}, portando ai gattini prede tramortite, con cui possono {! imparare i \"placcaggi\" :: marker3 !}. {! Alla fine :: marker1 !}, sottopone i piccoli alla prova più difficile, portando loro prede vive e quasi incolumi, sulle quali i gattini dovranno cercare, {! non senza difficoltà :: marker4 !}, di {! aver la meglio :: marker3 !}.<br><br>
Se è indubbio che {! la spinta :: marker2 !} a {! imparare le tecniche di caccia :: marker5 !} dei piccoli è ben salda nel loro comportamento, anche {! l'istinto della madre :: marker2 !} ad {! insegnare loro a cacciare :: marker5 !} è così forte da trarre in inganno con i gatti con cui dividiamo le nostre case.<br><br>
Ebbene, per qualche gatto, noi non siamo altro che dei teneri cuccioli cui insegnare come procurarsi il cibo.";
    }

    protected function markerLabels(): array
    {
        return [
            __('tests.132-category-1'),
            __('tests.132-category-2'),
            __('tests.132-category-3'),
            __('tests.132-category-4'),
            __('tests.132-category-5'),
            __('tests.132-category-6'),
        ];
    }
}
