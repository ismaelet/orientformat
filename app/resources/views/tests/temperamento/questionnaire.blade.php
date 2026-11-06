@pushOnce('styles')
    <style>
        .temperamento-scale {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            align-items: center;
            gap: 2rem;
        }

        .temperamento-description {
            color: var(--color-neutral-heading);
            font-size: 1.2rem;
            font-weight: 700;
            text-align: center;
        }

        .temperamento-options {
            display: grid;
            grid-template-columns: 1.2fr 1fr 0.8fr 0.8fr 1fr 1.2fr;
            align-items: center;
            gap: clamp(0.5rem, 1.3vw, 1rem);
            min-width: 0;
        }

        .temperamento-option {
            --option-color: var(--color-secondary-400);
            min-width: 0;
            cursor: pointer;
        }

        .temperamento-option[data-positive] {
            --option-color: var(--color-1-of-6, var(--color-primary-400));
        }

        .temperamento-circle {
            display: flex;
            width: 100%;
            aspect-ratio: 1;
            align-items: center;
            justify-content: center;
            border: 3px solid var(--option-color);
            border-radius: 50%;
            color: var(--option-color);
            font-size: clamp(1rem, 2vw, 1.5rem);
            font-weight: 700;
            transition:
                background-color 0.2s,
                color 0.2s;
        }

        .temperamento-option:hover .temperamento-circle,
        .temperamento-option input:checked + .temperamento-circle {
            background-color: var(--option-color);
            color: var(--color-neutral-50);
        }

        .temperamento-option input:focus-visible + .temperamento-circle {
            outline: 2px solid var(--option-color);
            outline-offset: 4px;
        }

        @media (min-width: 1024px) {
            .temperamento-scale {
                grid-template-columns: minmax(8rem, 1fr) minmax(0, 3fr) minmax(8rem, 1fr);
            }

            .temperamento-description:first-child {
                text-align: right;
            }

            .temperamento-description:last-child {
                text-align: left;
            }
        }

        .confirm-button {
            animation: confirm-button-entrance 0.2s ease-in-out;
        }

        @keyframes confirm-button-entrance {
            from {
                opacity: 0;
                translate: 0 1rem;
            }
            to {
                opacity: 1;
                translate: 0 0;
            }
        }
    </style>
@endPushOnce

<x-layouts.test :$title :$test>
    <div class="full-width py-20">
        <x-test.title :$test />

        @if ($completed)
            <div class="grid justify-items-center gap-8 py-10">
                <p>{{ __('Test completed') }}</p>
                <x-button :href="$test->nextUrl($student)">{{ __('Continue') }}</x-button>
            </div>
        @else
            <div x-data="{ current: 0, answers: @js($answers) }" class="grid gap-8 py-10">
                @if ($errors->any())
                    <div role="alert" class="text-error-500">
                        @foreach ($errors->all() as $message)
                            <p>{{ $message }}</p>
                        @endforeach
                    </div>
                @endif

                @foreach ($questions as $index => $question)
                    <fieldset x-show="current === {{ $index }}" @if ($index !== 0) x-cloak @endif>
                        <div class="temperamento-scale">
                            <p id="temperamento-negative-{{ $index }}" class="temperamento-description">
                                {{ $question[0] }}
                            </p>
                            <div
                                role="radiogroup"
                                aria-labelledby="temperamento-negative-{{ $index }} temperamento-positive-{{ $index }}"
                                class="temperamento-options"
                            >
                                @for ($score = 0; $score <= 5; $score++)
                                    <label class="temperamento-option" @if ($score >= 3) data-positive @endif>
                                        <input
                                            type="radio"
                                            name="field[{{ $index }}]"
                                            value="{{ $score }}"
                                            x-model="answers[{{ $index }}]"
                                            class="peer sr-only"
                                            aria-label="{{ $score }} / 5"
                                        />
                                        <span
                                            class="temperamento-circle"
                                            aria-hidden="true"
                                        >{{ str_repeat('·', $score < 3 ? 3 - $score : $score - 2) }}</span>
                                    </label>
                                @endfor
                            </div>
                            <p id="temperamento-positive-{{ $index }}" class="temperamento-description">
                                {{ $question[1] }}
                            </p>
                        </div>
                    </fieldset>
                @endforeach

                <div class="flex h-20 items-center justify-center">
                    <x-button
                        class="confirm-button"
                        x-cloak
                        x-show="current < {{ count($questions) - 1 }} && answers[current] != null"
                        x-bind:disabled="answers[current] === null || answers[current] === undefined"
                        x-on:click="if (answers[current] != null) current++;"
                    >{{ __('Confirm') }}</x-button>

                    <x-button
                        type="submit"
                        name="submit"
                        value="1"
                        class="confirm-button"
                        x-cloak
                        x-show="current === {{ count($questions) - 1 }} && answers[current] != null"
                        x-bind:disabled="answers.some((answer) => answer === null || answer === undefined)"
                    >{{ __('Confirm') }}</x-button>
                </div>
            </div>
        @endif
    </div>
</x-layouts.test>
