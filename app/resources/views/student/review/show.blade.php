@pushOnce('styles')
    <style>
        .page-content {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            align-items: center;
        }

        .checkbox {
            --border-clr-400: #aaa;
        }

        .completed {
            display: grid;
            align-content: center;
            justify-items: center;
            min-height: calc(100vh - 84px);
        }

        .success-icon {
            --icon-size: 70%;
            width: 6rem;
            aspect-ratio: 1;
            border: 0.5rem solid currentColor;
            border-radius: 50%;
            color: var(--color-good-400);
        }

        /* Questions */
        .question > .text {
            gap: 0.5rem;
            font-weight: 600;
            font-size: 1rem;
        }

        .question > .text .number {
            display: inline-block;
            width: max-content;
            color: var(--color-secondary-400);
            line-height: 1.3rem;
        }

        .question.question--completed > .text .number {
            display: none;
        }

        .question > .text .icon-embed {
            display: none;
            color: green;
            width: 1.5rem;
            height: 1rem;
            top: -3px;
            vertical-align: middle;
        }

        .question.question--completed > .text .icon-embed {
            display: inline-block;
        }

        .question .error-warning {
            display: none;
        }

        .review-grid {
            width: 100%;
            border: 1px solid #eee;
            border-width: 1px 0;
            margin-top: 1rem;
        }

        .grid-row {
            display: grid;
            grid-auto-flow: column;
            grid-auto-columns: minmax(0, 1fr);
            align-items: center;
            justify-items: center;
            padding-block: 0.5rem;
        }

        .grid-row--legend {
            grid-template-columns: 3fr;
        }

        .grid-row:nth-child(2n) {
            background-color: #f6f6f6;
        }

        .grid-cell {
            display: grid;
            width: 100%;
            justify-items: center;
        }

        .grid-cell--title {
            justify-content: left;
            padding-inline: 1rem;
        }

        .question .grid-text {
            font-size: 0.9rem;
        }

        .question .grid-text {
            font-size: 0.9rem;
        }

        .grid-row--head .grid-text {
            font-weight: 600;
            text-align: center;
        }

        .question .grid .cbx-box {
            margin: 0;
        }

        .question .cbx-icon {
            width: 1.2rem;
            height: 1.2rem;
        }

        .answers--list {
            display: grid;
            gap: 0.5rem;
        }

        .answers--inputs {
            display: grid;
            gap: 1rem;
        }

        #question-s2d3a,
        #question-s2d3b,
        #question-s2d3c,
        #question-s2d3d,
        #question-s6d3,
        #question-s7d3,
        #question-s7d4,
        #question-s7d5 {
            display: none;
        }

        .question.question--error {
            border-left: 3px solid #dc2626;
            background-color: rgb(220 38 38 / 5%);
            padding: 1rem;
            border-radius: 0.25rem;
        }

        .question.question--error > .text {
            color: #dc2626;
        }

        .question.question--error .error-warning {
            color: #dc2626;
        }

        .question {
            scroll-margin-top: 2rem;
        }
    </style>
@endpushOnce

<x-layouts.legacy-main>
    <form data-review-form class="page-content main-wrap" method="POST" action="{{ route('review.store', $review) }}">
        @csrf

        <input type="hidden" name="review_id" value="{{ $review->id }}" />

        @if ($legacyReview->completed)
            <div class="grid content-center justify-items-center gap-8 py-20 text-center">
                <div class="success-icon grid place-items-center">
                    <x-icon-correct class="w-2/3" />
                </div>

                <x-heading.main>Grazie per aver<br />completato il formulario</x-heading.main>

                <x-subheading.main>
                    Le tue risposte sono state salvate. Puoi cliccare qui sotto per continuare con le attività
                    proposte</x-subheading.main>

                <x-button href="{{ route('home') }}" variant="secondary">Continua le attività</x-button>
            </div>
        @else
            <div class="header pad-t-7">
                <h1 class="txt-3rem fa-center txt-sbold">{{ $legacyReview->title }}</h1>
                <p class="txt-12rem fa-center mar-t-2">{{ $legacyReview->description }}</p>
            </div>

            <!-- Questions -->
            <div class="questions pb-20">
                @php $i = 0; @endphp

                @foreach ($legacyReview->areas as $area)
                    <section class="section mar-b-4 mar-t-5">
                        <p class="stitle txt-c3 txt-15rem txt-sbold">{{ $area->title }}</p>

                        @if ($area->text)
                            <p>{{ $area->text }}</p>
                        @endif

                        @foreach ($area->getQuestions($legacyReview->id) as $key => $question)
                            @php $i++; @endphp

                            <!-- Question -->
                            <div
                                id="question-{{ $question->fullSlug }}"
                                class="question {{ $question->type ? 'mar-b-3' : '' }} js-question"
                                data-optional="{{ $question->optional }}"
                                data-completed="0"
                                data-multiple="{{ $question->multiple }}"
                            >
                                <p class="text mar-t-2">
                                    @if ($debugger)
                                        ({{ $question->fullSlug }})
                                    @endif
                                    @if ($question->text)
                                        {!! embed_icon('correct') !!}
                                        <span class="number">{{ $i }}.</span>
                                        {{ $question->text }}
                                    @endif
                                </p>

                                @switch ($question->type)
                                    @case ('grid')
                                        <!-- Grid -->
                                        <div class="review-grid js-grid">
                                            <!-- Head -->
                                            <div class="grid-row grid-row--head {{ $question->hasLegend ? 'grid-row--legend' : '' }}">
                                                @if ($question->hasLegend)
                                                    <span></span>
                                                @endif

                                                @foreach ($question->gridHeader as $content)
                                                    <p class="grid-text">{{ $content }}</p>
                                                @endforeach
                                            </div>

                                            <!-- Rows -->
                                            @foreach ($question->rows as $row)
                                                <!-- Row -->
                                                <div class="grid-row js-grid-row {{ $question->hasLegend ? 'grid-row--legend' : '' }}">
                                                    @if (isset($row['title']))
                                                        <p class="grid-cell grid-cell--title">{{ $row['title'] }}</p>
                                                    @endif

                                                    <!-- Cells -->
                                                    @foreach ($row['content'] as $cell)
                                                        <div class="grid-cell">
                                                            <label class="checkbox">
                                                                <input
                                                                    type="radio"
                                                                    class="field js-cbx"
                                                                    name="{{ $cell['name'] }}"
                                                                    value="{{ $cell['value'] }}"
                                                                    data-type="row"
                                                                />

                                                                <span></span>
                                                            </label>

                                                            @if ($debugger)
                                                                <p>{{ $cell['name'] . ' = ' . $cell['value'] }}</p>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                        @break
                                    @case ('list')
                                        <div class="answers answers--list mt-2">
                                            @foreach ($question->rows as $row)
                                                <label class="checkbox">
                                                    <input
                                                        type="radio"
                                                        name="{{ $row['name'] }}"
                                                        value="{{ $row['value'] }}"
                                                        class="field js-cbx"
                                                    />

                                                    <span></span>

                                                    <p class="">
                                                        {{ $row['title'] }}
                                                        @if ($debugger)
                                                            <strong>({{ $row['name'] . ' = ' . $row['value'] }})</strong>
                                                        @endif
                                                    </p>
                                                </label>
                                            @endforeach
                                        </div>
                                        @break
                                    @case ('number')
                                        <x-input
                                            type="number"
                                            class="field js-input mar-t-1"
                                            name="{{ $question->fullSlug }}"
                                            min="1"
                                            max="100"
                                            placeholder="Numero"
                                            required
                                        />
                                        @break
                                @endswitch
                            </div>
                        @endforeach
                    </section>
                @endforeach

                <div class="fa-center mar-t-3">
                    <button type="submit" id="submit" class="js-submit hidden"></button>
                    <x-button type="button" class="js-attempt-submit">Invia</x-button>
                </div>
            </div>

        @endif
    </form>
</x-layouts.legacy-main>
