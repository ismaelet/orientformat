<?php

namespace App\Legacy;

use Illuminate\Foundation\Vite;

class ScriptLoader
{
    private static $list = [];

    private static $headInlineScripts = [];

    private static $footInlineScripts = [];

    public static function __constructStatic() {}

    // load a script
    public static function add($fileName, $type, $priority = false)
    {
        $file = false;
        if (in_array($type, ['page', 'template'])) {
            $entry = 'resources/js/exercises/'.($type === 'page' ? 'pages' : 'templates').'/'.$fileName.'.js';
            if (is_file(base_path($entry))) {
                self::$list[] = [$priority ?: ($type === 'page' ? 4 : 3), $entry, true];

                return;
            }
        }

        switch ($type) {
            case 'template':
                if (file_exists(base_path().'/public/legacy'.$fetchingFile = '/templates/scripts/'.$fileName.'.js')) {
                    $file = $fetchingFile;
                    if (! $priority) {
                        $priority = 3;
                    }
                }
                break;
            case 'page':
                if (file_exists(base_path().'/public/legacy'.$fetchingFile = '/pages/scripts/'.$fileName.'.js')) {
                    $file = $fetchingFile;
                    if (! $priority) {
                        $priority = 4;
                    }
                }
                break;
            case 'inline':
                self::$footInlineScripts[] = $fileName;
        }

        // store the file URL in the list
        if ($file) {
            $file .= '?v='.filemtime(base_path().'/public/legacy'.$file);
            self::$list[] = [$priority, $file];
        }
    }

    public static function addPageScripts($pageName)
    {
        $pageScripts = glob(base_path().'/public/legacy'.'/pages/scripts/-expands-'.$pageName.'/*.js');

        self::add($pageName, 'page');

        foreach ($pageScripts as $pageScript) {
            self::add('-expands-'.$pageName.'/'.self::getFileName($pageScript), 'page', 5);
        }
    }

    // get the file name
    private static function getFileName($fileUrl)
    {
        return explode('.js', legacy_explode_last('/', $fileUrl))[0];
    }

    /*
    * Load the scripts
    */
    // load all the scripts
    public static function load()
    {
        $list = [];

        sort_subvalue(self::$list, 0);

        foreach (self::$list as $script) {
            $list[$script[1]] = ! empty($script[2])
                ? (string) app(Vite::class)($script[1])
                : '<script src="'.asset('legacy'.$script[1]).'"></script>';
        }

        return implode(PHP_EOL, $list);
    }

    // load the inline script to be placed in the head
    public static function loadHeadInline()
    {
        return implode(PHP_EOL.PHP_EOL, self::$headInlineScripts);
    }

    // load the inline script to be placed at the end of the body
    public static function loadFootInline()
    {
        return implode(self::$footInlineScripts);
    }
}
