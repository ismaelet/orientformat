<?php

namespace App\Helpers\Tests;

class ScrivereSemplificatoMappaHelper {
    public function getTypes() {
        $typeCount = 16;

        $types = [];

        for ($i = 1; $i <= $typeCount; $i++) {
            $types[] = __('tests.63-type-' . $i);
        }

        return $types;
    }
}
