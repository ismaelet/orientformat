<?php

$count = 13;

\Legacy\LogicManager\TestLogic::setParameterCount($count)
    ->setTestSubmitFunction(
        function () {
            $correctN = 0;

            if (empty($_POST['field'])) {
                return 0;
            }

            foreach ($_POST['field'] as $key => $_looping) {
                if (eval_num($_POST['field'], $key)) $correctN++;
            }

            return round($correctN / \Legacy\LogicManager\TestLogic::$parameterCount * 100, 0);
        }
    );

function eval_num($numbers, $key) {
    if (!isset($numbers[$key])) {
        return false;
    }

    if ($key) {
        $valid = true;
        $num = (int) $numbers[$key];
        $sibling = $key < 7 ? (int) $numbers[$key + 6] : (int) $numbers[$key - 6];
        $center = (int) $numbers[0];

        if ($num + $center + $sibling != 22) $valid = false;

        foreach ($numbers as $i => $val) if ($i != $key && $val == $num) $valid = false;

        return $valid;
    } else {
        if ($numbers[0] < 10) return true;
        else return false;
    }
}
