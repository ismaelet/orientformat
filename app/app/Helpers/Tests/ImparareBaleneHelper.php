<?php

namespace App\Helpers\Tests;

use App\Interfaces\TestHelperInterface;

class ImparareBaleneHelper implements TestHelperInterface {

    /**
     * Property: determines whether to show the marker labels in the view or not
     */
    public bool $showMarkerLabels = true;

    /**
     * Property: contains the original text with markers for selectable parts
     */
    protected string $text;

    /**
     * Property: counts the number of selectable parts in the text based on the markers
     */
    protected int $count;

    /**
     * Property: contains the HTML version of the text with spans for selectable parts, generated from the original text
     */
    protected array $solutions = [];

    /**
     * Constructor: initializes the text and generates the HTML version with selectable spans
     */
    public function __construct() {
        $this->text = $this->text();
        $this->count = substr_count($this->text, ':: marker');
        $this->buildSolutions();
    }

    /**
     * Helper method: get the original text
     */
    protected function text(): string {
        return __('tests.149-text');
    }

    /**
     * Helper method: returns the labels for the markers as an array of strings
     */
    protected function markerLabels(): array {
        return [
            __('tests.149-label-1'),
            __('tests.149-label-2'),
            __('tests.149-label-3'),
            __('tests.149-label-4'),
        ];
    }

    /**
     * Helper method: returns the markers for the test
     */
    public function markers() {
        $markers = [];
        $markerLabels = $this->markerLabels();

        foreach ($markerLabels as $key => $label) {
            $markers[] = [
                'label' => $label,
                'count' => substr_count($this->text, ' marker' . $key),
            ];
        }

        return $markers;
    }

    /**
     * Helper method: parses the original text to extract the correct markers for each selectable part and stores them in the solutions array
     */
    protected function buildSolutions(): void {
        $this->solutions = [];

        if (!preg_match_all('/\{\!\s*(.*?)\s*::\s*(marker\d+)\s*!\}/', $this->text, $matches, PREG_SET_ORDER)) {
            return;
        }

        foreach ($matches as $index => $match) {
            $partId = $index;
            $this->solutions[$partId] = $match[2];
        }
    }

    /**
     * Helper method: converts the text with markers into HTML with selectable spans
     */
    public function htmlText(?array $result): string {
        $partId = 0;
        $processedText = $this->text;

        while (strpos($processedText, '{!') !== false) {
            $previousText = explode('{! ', $processedText, 2)[0];
            $activePart = explode(' !}', explode('{! ', $processedText, 2)[1])[0];
            $followingText = explode(' !}', $processedText, 2)[1];

            $resultClass = $this->getResultClass($partId, $result);

            $activePart = explode(' :: ', $activePart);
            $activeText = $activePart[0];
            $markerType = $activePart[1];

            $activeText =
                '<span class="selectable js-selectable ' . $resultClass . '" data-part-id="' . $partId . '" data-text-type="' . $markerType . '">' .
                '<input type="hidden" class="js-answer" name="field[' . $partId . ']" value="">' .
                '<span class="js-selectable-text">' . $activeText . '</span>' .
                '</span>';

            $processedText = $previousText . $activeText . $followingText;

            $partId++;
        }

        return $processedText;
    }

    /**
     * Helper method: determines the CSS class to apply to a selectable part based on the user's selection
     */
    protected function getResultClass(int $partId, ?array $result): string {
        // If the test has not been completed don't return any result class
        if (!is_array($result)) {
            return '';
        }

        $chosenType = $result[$partId] ?? null;
        $correctType = $this->solutions[$partId] ?? null;

        // If the user did not select any option for this part return the unselected class
        if (!$chosenType) {
            return 'unselected';
        }

        // Otherwise check if the chosen answer matches the solution and return the correct or incorrect class
        return $chosenType === $correctType ? 'correct' : 'incorrect';
    }

    /**
     * Helper method: calculates the test result percentage based on the user's selections
     */
    public function calculatePercentage($results): int {
        if (!is_array($results) || $this->count === 0) {
            return 0;
        }

        $rightResults = 0;

        foreach ($this->solutions as $partId => $correctType) {
            $chosenType = $results[$partId] ?? null;

            if ($chosenType === $correctType) {
                $rightResults++;
            }
        }

        return (int) round(($rightResults / $this->count) * 100);
    }
}
