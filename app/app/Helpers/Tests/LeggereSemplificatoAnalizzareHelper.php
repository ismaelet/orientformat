<?php

namespace App\Helpers\Tests;

class LeggereSemplificatoAnalizzareHelper extends ImparareBaleneHelper
{
    protected function text(): string
    {
        return "Esemplare {! la fedeltà coniugale degli albatri :: marker0 !}, i grandi uccelli che veleggiano ad ali spiegate soprattutto {! nelle regioni subantartiche :: marker3 !}. E se ne comprende facilmente il motivo. Il loro uovo, uno solo, che pesa circa mezzo chilo, richiede {! un periodo d'incubazione lunghissimo :: marker1 !}, il più lungo che si conosca nel mondo degli uccelli: circa 80 giorni. In questo periodo i genitori si danno il cambio una volta alla settimana. Mentre l'uno cova, l'altro vola in mare a rifocillarsi. Nel momento in cui l'uno arriva dall’oceano e l'altro sta per involarsi, avviene un breve intermezzo di carezze {! volto a rinforzare il legame di coppia :: marker2 !}. Si lisciano reciprocamente le penne e lanciano acute grida quasi per infondersi coraggio reciprocamente. \"Ci vuol pazienza. Abbiamo un figlio da allevare\". Quando, infine, il piccolo sguscia dall’uovo, {! debbono passare ancora nove lunghi mesi prima che diventi autosufficiente :: marker1 !}. Nessun pulcino necessita di cure parentali così protratte nel tempo.<br>E non basta. Di regola gli albatri si riproducono ogni due anni. Ma {! se per disgrazia l'uovo va distrutto o il piccolo muore, la coppia fa uno strappo alla regola e si riproduce :: marker1 !} l'anno successivo. Così il tempo passa e {! l'unione diventa permanente :: marker0 !}.";
    }

    protected function markerLabels(): array
    {
        return [
            __('tests.37-category-1'),
            __('tests.37-category-2'),
            __('tests.37-category-3'),
            __('tests.37-category-4'),
        ];
    }
}
