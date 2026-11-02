{% block content %}

<div class="main-wrap pb-20">
    <div class="title__wrapper center-content mar-b-4">
        <?= title() ?>
    </div>

    <?php if ($results) { ?>

        <section class="interests">
            <?php

            $i = 0;

        foreach ($results as $result) {
            $i++;

            if ($result['percentage'] < 50 && $i > 5) {
                break;
            }
            ?>

                <?php if ($i == 1) { ?>

                    <h2 class="area_title subsection-title"><?= __('tests.92-subtitle-1') ?></h2>

                <?php } elseif ($i == 2) { ?>

                    <h2 class="area_title subsection-title"><?= __('tests.92-subtitle-2') ?></h2>

                <?php } ?>

                <a class="interest <?= $i == 1 ? 'interest--main' : 'interest--other' ?>" href="<?= route('interest', ['id' => $result['id'], 'student-id' => watchedStudentId(), 'highschool' => $isMiddleSchool ? 0 : 1]) ?>">
                    <img src="<?= client_path($isMiddleSchool ? '/pages/assets/interests/highschool/'.$result['id'].'.jpg' : '/pages/assets/interests/universities/'.$result['id']) ?>" alt="" class="interest_img img-fill">
                    <div class="interest_content">
                        <h3 class="interest_title"><?= $interests[$result['id']]['name'] ?></h3>
                        <h3 class="interest_value"><span class="txt-sbold"><?= $result['percentage'] ?>%</span> <?= __('of interest') ?></h3>
                        <p class="interest_info"><?= $interests[$result['id']]['info'] ?></p>

                        <?php if (! $supervisorView) { ?>

                            <div class="interest_link ebtn"><?= __('Discover this area') ?></div>

                        <?php } ?>

                    </div>
                </a>
            <?php } ?>

        </section>

    <?php } else { ?>

        <?= no_results() ?>

    <?php } ?>

    <?= submit() ?>

</div>

{% end content %}