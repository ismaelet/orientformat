{% block content %}

<div class="main-wrap pad-t-4 pb-20" autocomplete="off">

    <input type="hidden" id="record-time" name="field[]">

    <?= title() ?>

    <div id="content" class="mar-t-4 <?= $legacyTest->completed ? 'completed' : '' ?>">

        <div class="fa-center">
            <div id="start" class="button"><?= __('Start') ?></div>
        </div>

        <div id="concepts" class="fa-center">

            <?php foreach (_CONCEPTS as $key => $concept) { ?>

                <h2 class="concept txt-c3 mar-v-1 font-bold inlb loadA pos-rel" style="--del: <?= $key / 10 ?>s">
                    <span class="concept-line"></span>
                    <span class="block"><?= ucfirst($concept) ?></span>
                </h2><br>

            <?php } ?>

            <div class="fa-center mar-t-3">
                <div id="stop" class="button bgr-c5">Stop</div>
            </div>

        </div>

        <div id="answers">

            <?php for ($i = 0; $i < $count; $i++) { ?>

                <div class="answer">
                    <input type="text" name="field_other[]" class="inp filler-inp <?php if ($legacyTest->completed) echo in_array(strtolower($results[$i]), _CONCEPTS) ? 'right' : 'wrong' ?>" maxlength="40" required value="<?= $results[$i] ?? '' ?>" <?= $legacyTest->completed ? 'readonly' : '' ?>>
                    <h3 class="number font-bold txt-c3"><?= $i + 1 ?>.</h3>
                </div>

            <?php } ?>

            <?php if ($legacyTest->completed) { ?>

                <p id="result" class="txt-c3 txt-12rem mar-t-2">
                    Ti sei ricordato <?= $legacyTest->percentage ? 'il ' : 'lo ' ?><strong><?= $legacyTest->percentage ?>%</strong> dei concetti e ci hai messo <strong><?= $time_str ?></strong> per memorizzarli.
                </p>

            <?php } ?>

            <div class="mar-t-2">

                <?= submit(true) ?>
                <?= skip() ?>

            </div>
        </div>
    </div>
</div>

{% end content %}