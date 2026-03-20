<?php

namespace App\View\Components\Test;

use App\Models\Activities\Section;
use App\Models\Activities\Test;
use App\Models\Schools\SchoolClass;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component {

    /**
     * Property: The button label
     */
    public string $label;

    /**
     * Property: The button URL
     */
    public ?string $url = null;

    /**
     * Create a new component instance.
     */
    public function __construct(public Test $test, public bool $progressive = false) {
        $student = student();
        $watchedStudent = legacy_watched_student();
        $section = $test->section;
        $from = request()->query('from');
        $class = $student->class;
        $isSupervisor = isSupervisor();
        $testCompleted = $student->hasCompletedTest($test);
        $sectionCompleted = $student->hasCompletedSection($section);
        $requiresReview = $test->reviewResult;

        $this->label = $this->label($testCompleted, $sectionCompleted, $requiresReview, $isSupervisor, $from);

        $this->url = $this->url(
            testCompleted: $testCompleted,
            sectionCompleted: $sectionCompleted,
            requiresReview: $requiresReview,
            watchedStudent: $watchedStudent,
            isSupervisor: $isSupervisor,
            from: $from,
            class: $class,
            section: $section
        );
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string {
        return view('components.test.button');
    }

    /**
     * Determine the button label based on the test state
     */
    private function label(bool $testCompleted, bool $sectionCompleted, bool $requiresReview, bool $isSupervisor, ?string $from): string {
        return match (true) {
            // Supervisor view
            $from => __('Ritorna alle autovalutazioni'),

            // Supervisor view
            $isSupervisor => __('Return to the list of results'),

            // Completed test and section
            $testCompleted && $sectionCompleted => __('Return to the summary'),

            // Test that requires review
            $requiresReview && !$testCompleted => __('Check your answer'),

            // Uncompleted test, completed section
            $sectionCompleted => __('Save the new result'),

            // Default button
            default => __('Proceed'),
        };
    }

    private function url(bool $testCompleted, bool $sectionCompleted, bool $requiresReview, Student|Teacher $watchedStudent, bool $isSupervisor, ?string $from, Section $section, ?SchoolClass $class): ?string {
        if ($from) {
            $fromTest = Test::where('slug', $from)->first();
        }

        $nextUncompletedTest = Test::where('sectionId', $section->id)
            ->where('active', true)
            ->whereNotIn('id', $watchedStudent->test_results->where('completed', true)->pluck('testId'))
            ->orderBy('step')
            ->first();

        return match (true) {
            // Return to a specific url in supervisor view
            $from && $isSupervisor => route('class.students.self-evaluations.show', ['class' => $class, 'student' => $watchedStudent]),

            // Return to a specific url in student view
            $from => $fromTest?->url(student_id: $watchedStudent->id),

            // Return to the list of results in supervisor view
            $isSupervisor => route('class.students.results.show', ['class' => $class, 'student' => legacy_watched_student()]),

            // Return to the summary if both test and section are completed
            $testCompleted && $sectionCompleted => $section->url(),

            // Redirect to the next uncompleted test if available
            $testCompleted && $nextUncompletedTest => $nextUncompletedTest->url(),

            // Return to the section if no more tests are available
            $testCompleted => $section->url(),

            // Don't provide a URL if the test isn't completed
            default => null,
        };
    }
}
