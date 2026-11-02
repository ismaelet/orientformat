<?php

use Legacy\Activity\Test;

?>

{% block content %}

<div class="pt-20">

    <div class="main-wrap">

        <!-- Title -->
        <?= title() ?>

        <?php if (! $supervisorView) { ?>

            <!-- Link to the tale -->
            <a href="<?= (new Test(70))->clientUrl ?>">
                <p class="txt-c5 txt-1rem br-b-1 br-c5 inlb"><?= __('Read the story again') ?></p>
            </a>

        <?php } ?>

        <!-- Results -->
        <?php if ($legacyTest->completed) { ?>

            <p class="mar-t-2 txt-12rem font-bold">
                <?= __('tests.71-result', ['percentage' => $legacyTest->percentage]) ?>
            </p>

            <p class="txt-1rem">
                <?= __('tests.71-description') ?>
            </p>

        <?php } ?>

    </div>

    <?php if ($legacyTest->completed || ! $supervisorView) { ?>

        <!-- Questions -->
        <div id="questions" class="mar-t-3 mar-b-3 <?= $legacyTest->completed ? 'completed' : '' ?>">

            <?php foreach ($questions as $key => $question) { ?>

                <div class="question bgr-<?= $colors[$key % 4] ?>">

                    <div class="main-wrap pad-v-4">

                        <!-- Question -->
                        <div class="fa-center">
                            <p class="quote txt-2 txt-sbold txt-15rem inlb brb2">"<?= $question['text'] ?>"</p>
                        </div>

                        <!-- Answers -->
                        <div class="qustion__body">

                            <p class="question txt-2 fa-center txt-1rem txt-sbold mar-t-2"><?= __('tests.71-question-1') ?></p>

                            <div class="answers answers--characters">

                                <?php foreach ($question['answers'] as $i => $answer) {
                                    $val = $legacyTest->rawResults[$key - 1] ?? false;
                                    $resultClass = null;
                                    $cheched = ! legacy_test()->completed && $val && $val == $i + 1;

                                    if ($val && ($val == $i + 1 || $answers[$key - 1] == $i + 1)) {
                                        if ($val == $answers[$key - 1]) {
                                            $resultClass = 'right';
                                        } else {
                                            $resultClass = $val == $i + 1 ? 'wrong' : 'not-checked';
                                        }
                                    } ?>

                                    <div>
                                        <input type="checkbox" name="field[]" class="js-field hidden" <?= $cheched ? 'checked' : '' ?> value="<?= $i + 1 ?>">

                                        <p class="answer selection txt-12rem txt-sbold txt-2 br-2 clickable <?= legacy_test()->completed ? $resultClass : '' ?>">
                                            <?= $answer ?>
                                        </p>
                                    </div>

                                <?php } ?>

                            </div>
                        </div>

                        <!-- Emotions -->
                        <div class="emotions">
                            <input type="hidden" name="field_other[]" class="filler-inp js-field" value="">
                            <p class="question txt-2 fa-center txt-1rem txt-sbold mar-t-2"><?= __('tests.71-question-2') ?></p>
                            <div class="answers answers--emotions">

                                <?php foreach ($question['emotions'] as $i => $emotion) {
                                    $resultClass = null;
                                    $val = isset($results_emotions[$key - 1]) ? explode('+', $results_emotions[$key - 1]) : false;

                                    if ($val && $val[0] && (in_array($i + 1, $val) || in_array($i + 1, $answers_emotions[$key - 1]))) {
                                        if (in_array($i + 1, $answers_emotions[$key - 1]) && in_array($i + 1, $val)) {
                                            $resultClass = 'right';
                                        } else {
                                            $resultClass = in_array($i + 1, $val) ? 'wrong' : 'not-checked';
                                        }
                                    }
                                    ?>

                                    <div>
                                        <input type="checkbox" class="hidden" data-val="<?= $i + 1 ?>">

                                        <p class="emotion selection inlb txt-12rem txt-sbold br-2 clickable <?= $resultClass ?>">
                                            <?= $emotion ?>
                                        </p>

                                    </div>

                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>

        </div>

    <?php } ?>

    <div class="main-wrap grid" data-spacing="700">
        <?= no_results() ?>

        <div>
            <?= submit(true) ?>
            <?= skip() ?>
        </div>

        <?= renderRedoButton(true) ?>
    </div>
</div>

{% end content %}