<x-layouts.class-dashboard :$class>
    <div class="dashboard-header grid grid-cols-1 justify-items-center gap-8 text-center" x-data>
        <x-heading.main>{{ $reviewResult->review->title }}</x-heading.main>
        <p>Qui puoi trovare le principali risposte che lo studente/studentessa ha segnato nel questionario</p>
        <x-button href="{{ route('class.students.results.show', ['class' => $class, 'student' => $student]) }}" variant="secondary">
            Indietro
        </x-button>
        <x-button @click="window.print()">Stampa</x-button>
    </div>

    <div class="grid gap-4">
        @forelse ($answers as $question)
            <div class="card grid gap-4">
                <p><strong>{{ $question['slug'] }}.</strong> {{ $question['question'] }}</p>
                @foreach ($question['answers'] as $answer)
                    <p>
                        @if ($answer['label'] !== '')
                            {{ $answer['label'] }}:
                        @endif
                        <strong>{{ $answer['value'] }}</strong>
                    </p>
                @endforeach
            </div>
        @empty
            <p>Non ci sono risposte disponibili per questo questionario.</p>
        @endforelse
    </div>
</x-layouts.class-dashboard>
