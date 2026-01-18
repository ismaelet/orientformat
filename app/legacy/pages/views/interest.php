{% block main %}

<div class="pad-v-7">
    <div class="page-content">

        <!-- Presentation -->
        <div class="main-wrap">
            <section class="presentation">
                <img src="<?= client_path(!$highschool ? '/pages/assets/interests/highschool/' . $interestId . '.jpg' : '/pages/assets/interests/universities/' . $interestId) ?>" alt="" class="interest_img img-fill">
                <div class="interest_content grid" data-spacing="400">
                    <h1 class="interest_title"><?= $interest['name'] ?></h1>

                    <?php if (!$watch) { ?>

                        <h3 class="interest_value txt-12rem"><span class="txt-sbold"><?= $result ?>%</span> di interesse</h3>

                    <?php } ?>

                    <p class="interest_info txt-1rem"><?= $interest['info'] ?></p>

                    <a href="<?= client_url($watch ? '/choose/section?id=' . ($highschool ? 44 : 23) . '#area' . $interestId : '/choose/section?id=' . ($highschool ? 45 : 24) . '&test-id=' . $resultTestId . '&studentId=' . $studentId) ?>" class="button button--secondary">Indietro</a>
                </div>
            </section>
        </div>

        <?php if (!$watch) { ?>

            <!-- Answers -->
            <form class="answers mar-t-3" id="answers" method="POST">
                <?= csrf_field() ?>
                <div class="main-wrap">
                    <h2 class="section-title">Risposte</h2>
                    <p class="fa-center">Queste sono le risposte che hai dato in quest’area. Se vuoi, puoi modificarle e visionare i risultati successivi alle modifiche.</p>

                    <div class="fa-center mar-t-1">
                        <button class="button js-asnwers-edit" name="edit">Salva le modifiche</button>
                    </div>

                    <div class="answer-list mar-t-2">

                        <?php foreach ($questionIds as $questionId) { ?>

                            <div class="question editable">
                                <div class="name-box grid">
                                    <p class="name"><?= $questionId ?>. <?= $questions[$questionId] ?></p>
                                </div>

                                <div class="score-box txt-rig">

                                    <?php for ($i = 0; $i <= 3; $i++) { ?>

                                        <label class="score<?= $i ?> score <?= $studentId != \Illuminate\Support\Facades\Auth::id() ? 'score--supervisor' : '' ?>">

                                            <input type="checkbox" class="hidden filler-inp" name="field[<?= $questionId - 1 ?>]" value="<?= $i + 1 ?>" <?= isset($survey->rawResults[$questionId - 1]) && $i + 1 == $survey->rawResults[$questionId - 1] ? 'checked' : '' ?>>

                                            <div class="circle">
                                                <div class="dot cen"></div>
                                            </div>

                                            <p class="fa-center"><?= $i ?></p>

                                        </label>

                                    <?php } ?>

                                </div>
                            </div>

                        <?php } ?>

                    </div>
                </div>
            </form>

        <?php } ?>

        <!-- Scuole -->
        <?php if ($schoolList) { ?>

            <div class="main-wrap">
                <section class="mar-t-3">
                    <h2 class="section-title <?= $watch ? 'section-title--watching' : '' ?>"><?= $highschool ? __('Beyond the diploma') : __('Programs and schools') ?></h2>
                    <p class="fa-center"><?= $highschool ? '' : __('These are the schools in the provincial area that offer specialized studies in this field.') ?></p>

                    <ul class="school-list mar-t-4">

                        <?php if ($highschool) {
                            foreach ($schoolList as $pathName => $pathData) {

                                if ($pathName == 'referent') {
                                    continue;
                                }

                        ?>

                                <!-- School type -->
                                <li class="school-type grid" data-spacing="700">
                                    <h3 class="school-type_title txt-sbold txt-15rem"><?= $pathName ?></h3>

                                    <?php if (!empty($pathData['description'])) { ?>

                                        <p class="school-type__description"><?= $pathData['description'] ?></p>

                                    <?php } ?>

                                    <ul class="courses">

                                        <?php foreach ($pathData['roles'] as $roleName => $role) { ?>

                                            <!-- Course -->
                                            <li class="course grid" data-spacing="200">
                                                <h3 class="txt-sbold txt-125rem"><?= $roleName ?></h3>
                                                <ul class="role__data-list">

                                                    <?php if (!empty($role['where'])) { ?>

                                                        <li class="role__data">
                                                            <div>
                                                                <span class="font-bold">Dove lavora:</span> <?= $role['where'] ?>
                                                            </div>
                                                        </li>

                                                    <?php } ?>

                                                    <?php if (!empty($role['description'])) { ?>

                                                        <li class="role__data">
                                                            <div>
                                                                <?= $role['description'] ?>
                                                            </div>
                                                        </li>

                                                    <?php } ?>

                                                    <?php if (!empty($role['activities'])) { ?>

                                                        <li class="role__data">
                                                            <div>
                                                                <span class="font-bold">Attività:</span>
                                                                <ul>
                                                                    <?php foreach ($role['activities'] as $activity) { ?>

                                                                        <li class="role__activity"><?= $activity ?></li>

                                                                    <?php } ?>
                                                                </ul>
                                                            </div>
                                                        </li>

                                                    <?php } ?>

                                                    <?php if (!empty($role['addresses'])) { ?>

                                                        <li class="role__data">
                                                            <div>
                                                                <ul>
                                                                    <?php foreach ($role['addresses'] as $address) { ?>

                                                                        <li class="role__activity"><?= $address ?></li>

                                                                    <?php } ?>
                                                                </ul>
                                                            </div>
                                                        </li>

                                                    <?php } ?>

                                                    <?php if (!empty($role['links'])) { ?>

                                                        <li class="role__data">
                                                            <div>
                                                                <ul>
                                                                    <?php foreach ($role['links'] as $link) { ?>

                                                                        <li class="role__activity"><a class="text-link" href="<?= $link['link'] ?>"><?= $link['name'] ?></a></li>

                                                                    <?php } ?>
                                                                </ul>
                                                            </div>
                                                        </li>

                                                    <?php } ?>

                                                </ul>
                                            </li>

                                        <?php } ?>

                                    </ul>

                                    <?php if (isset($pathData['explore'])) { ?>

                                        <div class="grid" data-spacing="400">
                                            <p class="font-bold txt-1rem">Per approfondire la tua ricerca puoi consultare questi siti:</p>
                                            <ul>
                                                <?php foreach ($pathData['explore'] as $exploreLink) { ?>

                                                    <li class="explore__link text-link"><a href="<?= $exploreLink ?>"><?= $exploreLink ?></a></li>

                                                <?php } ?>
                                            </ul>
                                        </div>

                                    <?php } ?>

                                </li>

                            <?php } ?>

                            <?php if (isset($schoolList['referent'])) {
                                if (isset($schoolList['referent']['name'])) {
                                    $referent = $schoolList['referent'];

                                    include __DIR__ . '/interests/referent.php';
                                } else {
                                    foreach ($schoolList['referent'] as $referent) {
                                        include __DIR__ . '/interests/referent.php';
                                    }
                                }
                            } ?>

                            <?php } else {
                            foreach ($schoolList as $schoolTypeName => $courses) {

                                if ($schoolTypeName == 'referent') {
                                    continue;
                                } ?>

                                <!-- School type -->
                                <li class="school-type">
                                    <h3 class="school-type_title txt-sbold txt-15rem"><?= $schoolTypeName ?></h3>

                                    <ul class="courses">
                                        <?php foreach ($courses as $courseName => $jobs) { ?>

                                            <!-- Course -->
                                            <li class="course">
                                                <h3 class="txt-sbold txt-125rem"><?= $courseName ?></h3>

                                                <ul class="jobs">
                                                    <?php foreach ($jobs as $jobName => $schools) { ?>

                                                        <!-- Job -->
                                                        <li class="job">
                                                            <h3 class="job_title txt-sbold"><?= $jobName ?></h3>

                                                            <ul class="schools">
                                                                <?php foreach ($schools as $school) { ?>

                                                                    <!-- School -->
                                                                    <li class="school">
                                                                        <h3 class="school_title txt-med">&middot; <?= $school['name'] ?><?= !empty($school['location']) ? ' - ' . $school['location'] : '' ?></h3>
                                                                        <?php if (!empty($school['link'])) { ?>
                                                                            <p class="txt-sbold"><a class="fc-primary-h" href="<?= $school['link'] ?>">Sito web</a></p>
                                                                        <?php } ?>
                                                                        <?php if (!empty($school['phone'])) { ?>
                                                                            <p class="txt-sbold">Tel. <a class="fc-primary-h" href="tel:<?= $school['phone'] ?>"><?= $school['phone'] ?></a></p>
                                                                        <?php } ?>
                                                                    </li>

                                                                <?php } ?>

                                                            </ul>
                                                        </li>

                                                    <?php } ?>

                                                </ul>
                                            </li>

                                        <?php } ?>
                                    </ul>
                                </li>

                            <?php } ?>

                            <?php if (isset($schoolList['referent'])) {
                                if (isset($schoolList['referent']['name'])) {
                                    $referent = $schoolList['referent'];

                                    include __DIR__ . '/interests/referent.php';
                                } else {
                                    foreach ($schoolList['referent'] as $referent) {
                                        include __DIR__ . '/interests/referent.php';
                                    }
                                }
                            } ?>
                        <?php } ?>

                    </ul>
                </section>
            </div>

        <?php } ?>

    </div>
</div>

{% end main %}