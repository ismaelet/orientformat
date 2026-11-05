<?php

namespace App\Http\Controllers\Activities;

use App\Legacy\LegacyTestController;
use App\Models\Activities\Test;

class TestNextController extends LegacyTestController
{
    protected $resultCount = 0;

    protected $buttonIsProgressive = false;

    protected $skipEnabled = false;

    protected $retryEnabled = false;

    protected $parameters = [];

    /**
     * Get method
     */
    public static function get(int $id)
    {
        return self::specificTest($id)->init();
    }

    /**
     * Post method
     */
    public static function post($id)
    {
        // get the score
        $score = self::specificTest($id)->calcResult($_POST['field'] ?? [], $_POST['result_count'] ?? 0);

        // save the results
        $result = ! empty($_POST['field']) ? implode(',', $_POST['field']) : '';

        // get the speed
        $speed = $_POST['speed'] ?? 0;

        // get if the test is completed
        $completed = ! isset($_POST['skip']) ? 1 : 0;

        // save result
        legacy_test()->saveResult($result, $score, $completed, $speed);
    }

    /**
     * For child hineritance
     */
    protected function view()
    {
        // execute the logic
        $this->logic();

        // store the template
        $this->storeTemplate($this->template());

        // store the scripts
        $this->storeInlineScripts([$this->scripts()]);

        // store the style
        $this->storeInlineStyles([$this->style()]);

        // store the parameters
        $this->storeParameters(
            array_merge(
                $this->parameters,
                [
                    'resultCount' => $this->resultCount,
                    'buttonIsProgressive' => $this->buttonIsProgressive,
                    'skipEnabled' => $this->skipEnabled,
                    'retryEnabled' => $this->retryEnabled,
                    'legacyTestController' => $this,
                ]
            )
        );

        $this->index();
    }

    protected function logic() {}

    protected function template() {}

    protected function scripts() {}

    protected function style() {}

    /**
     * Misc
     */
    private static function specificTest(int $id)
    {
        $test = Test::with('section')->findOrFail($id);
        $namespace = 'App\\Http\\Controllers\\Activities\\Tests';
        $controller = 'Test'.$test->id;

        if (! file_exists(__DIR__.'/Tests/'.$controller.'.php')) {
            $controller = hypens_to_camel_case($test->section->slug, true).hypens_to_camel_case($test->slug, true);
        }

        $fullController = $namespace.'\\'.$controller;

        return $fullController::getInstance();
    }
}
