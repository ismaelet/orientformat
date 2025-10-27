{% block content %}

<div class="main-wrap grid" data-spacing="800">
    <div class="title__wrapper">
        <?= title() ?>
    </div>

    <div class="page-content">
        <div class="riddles">

            <?php foreach ($riddles as $key => $riddle) { ?>

                <div class="riddle">
                    <p class="riddle__anagram"><?= $riddle[0] ?></p>
                    <p class="riddle__definition"><?= $riddle[1] ?></p>
                    <input type="text" class="js-field <?= legacy_test()->completed ? (strtoupper(legacy_test()->rawResults[$key]) == $riddle[2] ? 'test-input--correct' : 'test-input--wrong') : null ?>" name="field[]" value="<?= legacy_test()->completed ? strtoupper(legacy_test()->rawResults[$key]) : null ?>" placeholder="Parola" <?= legacy_test()->completed || isSupervisor() ? 'readonly' : null ?>>
                </div>

            <?php } ?>

        </div>
    </div>

    <div>
        <?= submit(true) ?>
        <?= skip() ?>
    </div>
</div>

{% end content %}