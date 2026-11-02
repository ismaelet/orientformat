<?php

namespace App\Legacy;

class Logic
{
    public const DEFAULT_TEMPLATE_PRIORITY = 50;

    public const DEFAULT_PAGE_PRIORITY = 150;

    private static $files = [];

    public static $priorities = [
        'blank' => 0,
        'main' => self::DEFAULT_TEMPLATE_PRIORITY,
        'void' => self::DEFAULT_TEMPLATE_PRIORITY,
        'form' => self::DEFAULT_TEMPLATE_PRIORITY + 10,
        'header' => self::DEFAULT_TEMPLATE_PRIORITY + 20,
        'footer' => self::DEFAULT_TEMPLATE_PRIORITY + 20,
        'test' => 200,
        'test-next' => 210,
        'survey' => 60,
        'student-read' => 70,
    ];

    public static $dependencies = [
        'main' => ['blank', 'header', 'footer'],
        'void' => 'blank',
        'form' => 'main',
        'test' => 'main',
        'survey' => 'main',
        'student-read' => 'main',
        'test-next' => 'test',
    ];

    // add a file
    public static function add($fileName, $type, $priority = false)
    {
        $file = false;

        switch ($type) {
            case 'template':
                // template file
                if (file_exists($fetchingFile = server_path('/app/templates/logic/'.$fileName.'.php'))) {
                    $file = $fetchingFile;
                } elseif (file_exists($fetchingFile = server_path('/system/templates/logic/'.$fileName.'.php'))) {
                    $file = $fetchingFile;
                }

                $priority = $priority ?: (self::$priorities[$fileName] ?? self::DEFAULT_TEMPLATE_PRIORITY);

                break;

            case 'page':
                // page file
                if (file_exists($fetchingFile = server_path('/pages/logic/'.$fileName.'.php'))) {
                    $file = $fetchingFile;
                }

                $priority = $priority ?: self::DEFAULT_PAGE_PRIORITY;

                break;
        }

        if ($type == 'template' && isset(self::$dependencies[$fileName])) {
            foreach ((array) self::$dependencies[$fileName] as $dependency) {
                self::add($dependency, 'template');
            }
        }

        self::$files[$type.'.'.$fileName] = [
            'name' => $fileName,
            'type' => $type,
            'priority' => $priority,
            'url' => $file,
        ];
    }

    // load all the files
    public static function load()
    {
        sort_subvalue(self::$files, 'priority');

        foreach (self::$files as $file) {
            if ($file['url']) {
                self::loadFile($file['url']);
            }

            if ($file['type'] == 'template') {
                StyleLoader::add($file['name'], 'template');
                ScriptLoader::add($file['name'], 'template');
            }
        }
    }

    private static function loadFile($__file)
    {
        include_once $__file;

        $variables = get_defined_vars();

        foreach ($variables as $key => $value) {
            if (! in_array($key, ['__file'])) {
                if (! is_array($value) || array_is_list($value)) {
                    LegacyView::set($key, $value);
                } else {
                    foreach ($value as $arrayKey => $arrayValue) {
                        LegacyView::set($key, $arrayValue, $arrayKey);
                    }
                }
            }
        }
    }
}

if (! function_exists('array_is_list')) {
    function array_is_list(array $array): bool
    {
        $i = 0;
        foreach ($array as $k => $v) {
            if ($k !== $i++) {
                return false;
            }
        }

        return true;
    }
}
