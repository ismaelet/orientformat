<?php

namespace App\Helpers\Tests;

class ImparareProbabileHelper extends ImparareBaleneHelper
{
    public bool $showMarkerLabels = false;

    protected function text(): string
    {
        return __('tests.185-text');
    }

    protected function markerLabels(): array
    {
        return [
            __('tests.185-label-1'),
        ];
    }
}
