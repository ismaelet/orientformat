<?php

namespace App\Helpers\Tests;

class LeggereEspertoPuntoDiVistaHelper extends ImparareBaleneHelper
{
    protected function text(): string
    {
        return "
		{! Seduta alla finestra :: marker0 !} guardava {! la sera invadere il viale :: marker1 !}. {! Teneva la testa appoggiata contro le tendine :: marker0 !} e sentiva nelle narici {! l'odore della cretonne polverosa :: marker1 !}. Era stanca.
{! Poca gente per strada :: marker1 !}. {! Passò l'inquilino della casa di fondo che rientrava :: marker1 !}. Lei ne sentì {! i passi risuonare sul marciapiede di cemento :: marker1 !}, poi scricchiolare sul sentiero di cenere dinanzi alle nuove case di color rosso. 

Ne avrebbe cominciata un'altra, con Frank. Era buono e forte Frank, e di cuore generoso. Sarebbe scappata con lui sul piroscafo della notte, e sarebbe diventata sua moglie, avrebbero vissuto insieme a Buenos Aires, dove lui aveva una casa che la aspettava. Come ricordava bene la prima volta che l'aveva visto! Aveva preso alloggio in una casa sulla strada principale, dove lei aveva degli amici. Le pareva fossero passate poche settimane da allora. {! Lui era al cancello, il berretto a visiera tirato all'indietro sulla nuca e i capelli che gli ricadevano sulla fronte abbronzata :: marker1 !}. Poi si erano conosciuti. 

{! La sera s'andava infittendo sul viale :: marker0 !} e {! il bianco delle due lettere che aveva in grembo si faceva indistinto :: marker1 !}. Una era per Harry, l'altra per il padre. Il suo prediletto, veramente, era stato Ernest, ma anche a Harry voleva bene. Aveva notato che negli ultimi tempi il padre stava invecchiando; lei gli sarebbe mancata. A volte sapeva essere gentile. Non molto tempo prima, un giorno che era stata a letto, malata, s'era  messo a leggerle una storia di fantasmi e le aveva abbrustolito il pane sul fuoco.

Il tempo passava ma {! lei rimaneva lì seduta presso la finestra, la testa appoggiata  contro le tendine :: marker0 !} e {! l'odore polveroso della cretonne nelle narici :: marker1 !}. Giù dal viale sentiva salire {! il lontano suono di un organetto :: marker1 !}. Era un motivo che conosceva. Strano che venisse proprio quella sera a rammentarle la promessa fatta alla madre, la promessa di badare alla famiglia più a lungo che avesse potuto. Le tornò a mente l'ultima notte della malattia della madre. Si rivide {! nella stanza buia, chiusa, dall'altra parte dell'anticamera: da fuori giungeva una melanconica aria italiana :: marker1 !}. Ricordava il padre che rientrava pomposo nella camera dell'ammalata dicendo: «Dannati italiani! Proprio qui debbono venire!».

{! Balzò in piedi con un subitaneo moto di terrore :: marker0 !}. Fuggire! Fuggire doveva! Frank l'avrebbe salvata. Le avrebbe dato una vita e forse anche l'amore. E in ogni modo  lei voleva vivere. Perché avrebbe dovuto essere infelice? Aveva diritto alla felicità. Frank l'avrebbe presa fra le braccia, l'avrebbe stretta fra le braccia, l'avrebbe salvata.

{! Era alla stazione di North Wall, in mezzo alla folla ondeggiante :: marker0 !}. Egli la teneva per mano e lei sapeva che le stava parlando, che le ripeteva qualche cosa sulla traversata. La stazione era piena di soldati coi loro bagagli scuri e attraverso le ampie porte della tettoia si scorgeva a tratti, lungo la murata della banchina, {! la massa immobile e nera della nave, con gli oblò illuminati :: marker0 !}. Lei non rispondeva. Si sentiva  {! le guance pallide e fredde :: marker1 !} e da un confuso fondo di disperazione pregava Dio di guidarla, di mostrarle qual era il suo dovere. {! La nave lanciò nella nebbia un lungo, luttuoso ululo di sirena :: marker1 !}. Se partiva, domani si sarebbe trovata in alto mare, con Frank, diretta a Buenos Aires. I posti erano fissati. Come poteva tirarsi indietro dopo tutto quel che Frank aveva fatto per lei? Lo sgomento le dette quasi un senso di nausea: {! continuava a muovere le labbra :: marker0 !} in tacita e fervida preghiera.";
    }

    protected function markerLabels(): array
    {
        return [
            '<strong>Del narratore</strong><br>(oggettiva)',
            '<strong>Del personaggio</strong><br>(soggettiva)',
        ];
    }
}
