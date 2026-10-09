{% block content %}

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Attach dragstart to all draggable divs
        document.querySelectorAll('.draggable').forEach(div => {
            div.addEventListener('dragstart', e => {
                e.dataTransfer.setData('text/plain', div.textContent.trim());
                e.dataTransfer.setData('elementId', div.id);
                e.dataTransfer.setData('id', div.dataset.id);
            });
        });

        // Enable inputs to accept drops
        document.querySelectorAll('.droppable').forEach(element => {
            element.addEventListener('dragover', e => e.preventDefault());

            element.addEventListener('drop', e => {
                const input = element.querySelector('input');
                const label = element.querySelector('.option');

                e.preventDefault();
                const text = e.dataTransfer.getData('text/plain');
                const id = e.dataTransfer.getData('id');
                const elementId = e.dataTransfer.getData('elementId');
                const div = document.getElementById(elementId);

                // If input already has a linked div, show it again
                if (element.dataset.divId) {
                    const oldDiv = document.getElementById(element.dataset.divId);
                    oldDiv.style.display = 'inline-block';
                }

                // Hide the newly dropped div
                div.style.display = 'none';

                // Update input value and remember which div it holds
                input.value = id;
                label.textContent = text;
                input.dispatchEvent(new Event('change'));
                element.dataset.divId = elementId;
            });
        });
    });
</script>

<div class="pt-20 pb-20 main-wrap">

    <?= title() ?>

    <?php if ($legacyTest->completed || !isSupervisor()) { ?>

        <div id="text-box" class="section grid grid-cols-1 gap-8">

            <h1 class="fa-center txt-3rem mar-b-2 mar-t-5 font-bold txt-upp"><?= __('Summary') ?></h1>

            <!-- Text -->
            <div class="summary-text"><?= $text ?></div>

            <!-- Draggable options -->
            <?php if (!legacy_test()->completed) { ?>
                <div class="flex gap-4 wrap justify-center <?= isSupervisor() ? 'pointer-events-none' : '' ?>">
                    <?php foreach ($options as $key => $option) { ?>
                        <p id="draggable-<?= $key ?>" class="border px-2 rounded-sm draggable-option draggable" draggable="true" data-id="<?= $option['id'] ?>"><?= $option['text'] ?></p>
                    <?php } ?>
                </div>
            <?php } ?>

            <!-- Read the full text -->
            <p class="clickable text-secondary-400 flex wrap items-center gap-2" onclick="$('.section').toggleClass('hidden');">
                <span class="text-icon text-c3"> <?= embed_icon('read') ?></span>
                <span class="btn-txt"><?= __('Click here to read the text again') ?></span>
            </p>
        </div>

        <div id="original-box" class="section hidden">

            <h1 class="fa-center txt-3rem mar-b-2 mar-t-5 font-bold txt-upp">Testo</h1>

            <p id="original" class="mar-b-2 txt-1rem">
                <?= __('tests.39-full-text') ?>
            </p>

            <p class="clickable mar-b-2 txt-c3 fc-primary-h inlb" onclick="$('.section').toggleClass('hidden');">
                <span class="text-icon text-c3"><?= embed_icon('navigation/back') ?></span>
                <span class="btn-txt"><?= __('tests.39-back') ?></span>
            </p>
        </div>

    <?php } ?>

    <?= no_results() ?>
    <?= submit(true) ?>
    <?= skip() ?>

</div>

{% end content %}