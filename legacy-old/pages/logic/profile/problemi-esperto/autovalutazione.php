<?php

$graph_data = $graph_data ?? [
	['Gestione delle emozioni', "Per farsi carico di un problema è necessario tenere a bada le emozioni negative, come l’ansia e la paura di non farcela. Come ci riesci?"],
	['Relazioni con gli altri', "Gli altri possono essere di ostacolo alla soluzione di un problema oppure un’importante risorsa, se si riesce a collaborare, rinunciando anche a qualcosa."],
	['Studio', "Apprendere significa mettersi alla prova su ciò che ancora non si sa o non si sa fare. Lo studio è una risorsa per affrontare questi problemi. Tu come lo usi?"],
	['Problemi di ordine pratico', "Nella vita di tutti i giorni si incontrano continuamente problemi più o meno seri o fastidiosi. Tu come reagisci?"],
	['Gestione del tempo', "Evitare due errori opposti: obiettivi troppo ambiziosi per tempi troppo brevi e tempi troppo lunghi per obiettivi molto facili."],
	['Organizzazione', "I problemi si risolvono se si dispone delle risorse sufficienti e si tiene conto dei vincoli."],
	['Impegno e perseveranza', "Non basta avere buone intuizioni e idee brillanti, si deve anche mantenere il giusto livello di impegno per il tempo necessario."],
	['Concentrazione', "Nel caso di problemi impegnativi, si deve mantenere l’attenzione sul compito, evitando distrazioni prolungate e devianti."],
	['Salute ', "Quando stai male, fisicamente o psicologicamente, quanto riesci a reagire, mobilitando le tue energie per riprenderti?"],
];

include_once(__DIR__ . '/../' . test()->section->mainSection->slug . '/' . test()->slug . '.php');

StyleLoader::add(test()->area->slug . '/' . test()->section->mainSection->slug . '/' . test()->slug, 'page');
ScriptLoader::add(test()->area->slug . '/' . test()->section->mainSection->slug . '/' . test()->slug, 'page');
