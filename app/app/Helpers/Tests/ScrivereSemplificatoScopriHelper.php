<?php

namespace App\Helpers\Tests;

class ScrivereSemplificatoScopriHelper extends ImparareBaleneHelper
{
    public string $title = "L'8 MARZO È LA FESTA DELLA DONNA. PARLA DELLA CONDIZIONE FEMMINILE";

    protected function text(): string
    {
        return "
		Io pen{! z :: marker0 !}o {! (e credo) :: marker1 !} che la donna {! deve :: marker2 !} essere uguale {! a l' :: marker0 !}uomo, perché non è giusto che non {! è :: marker2 !} uguale. L'8 Marzo la donna deve essere uguale all'uomo! In quel giorno tutti gli uomini portano le mimose alle donne e anche agli altri uomini, però io conosco un uomo che l'8 Marzo a una donna {! gli :: marker1 !} diede un calcio. {! Melo :: marker0 !} ha raccontato mio padre.<br>
Mio padre {! porta :: marker1 !} i tram adesso, ma una volta faceva il pompiere. Allora accadde che una donna {! dell :: marker1 !}8 Marzo si voleva buttare giù dal te{! r :: marker0 !}a{! z :: marker0 !}o e chiamarono i pompieri. Mio padre era quello che saliva sulle case per non fare gettare la gente dai palazzi. Lui salì, e quando si trovò faccia a faccia con la pazza {! gli :: marker1 !} disse: «Ma tu perché ti vuoi buttare per farci passare un guaio a noi?». Allora quella un poco {! s :: marker0 !}i pen{! z :: marker0 !}ò ancora se si voleva buttare o ritornare nel salotto, e pen{! z :: marker0 !}ò di buttarsi. Ma anche mio padre si buttò su di lei e la prese. Quando scesero giù, un amico di mio padre, che era pompiere (ma giù) diede un calcio alla pazza per la paura che s'era preso. Io se {! ero :: marker2 !} quel signore il calcio non glielo {! davo :: marker2 !} quel giorno ch'era l'8 Marzo, un altro giorno sì.<br><br>Da D’Orta M. (1994), <span class='italic'>Io speriamo che me la cavo. Sessanta temi di bambini napoletani</span>, Mondadori, Milano
";
    }

    protected function markerLabels(): array
    {
        return [
            __('tests.135-error-type-1'),
            __('tests.135-error-type-3'),
            __('tests.135-error-type-4'),
        ];
    }
}

// \Legacy\LogicManager\TestLogic::setParameterCount($count)
//     ->setTestSubmitFunction(function ($count) {
//         $score = 0;

//         foreach ($_POST['field'] as $result) {
//             if ($result) {
//                 $score++;
//             }
//         }

//         return round($score / $count * 100);
//     });
