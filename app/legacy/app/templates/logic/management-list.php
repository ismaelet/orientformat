<?php

use Illuminate\Support\Facades\DB;

// template
$this->add_logic('main', 'template');
$this->styles->add(SERVER_ROOT.'/app/templates/styles/management-list.css');
$this->scripts->add(SERVER_ROOT.'/app/templates/scripts/management-list.js');

// page logic
if (file_exists($file = SERVER_ROOT.'/pages/logic/'.$this->name.'.php')) {
    include_once $file;
}

// setup variables
$actions = $actions ?? false;
$back = $back ?? false;
$searchSQL = $searchSQL ?? ['', []];
$search_bar = $search_bar ?? true;

// fetch data
$res = $res ?? tap(DB::table($tbl)->where('status', 1), function ($query) use ($searchSQL) {
    $search = preg_replace('/^\s*(AND|OR)\s+/i', '', trim($searchSQL[0]));

    if ($search !== '') {
        $query->whereRaw($search, $searchSQL[1]);
    }
})->orderByDesc($index)->limit(50)->get();

$list = [];

foreach ($res as $row) {
    $list[] = (array) $row;
}

// delete entry
if (isset($_POST['delete'])) {

    DB::table($tbl)->where($index, $_POST[$index])->update(['status' => 0]);

    redirect_old();
}

// download list
if (isset($_POST['download'])) {

    $array = [];

    foreach ($list as $entry) {

        $line = [];

        foreach ($fields as $field) {

            $type = $field['type'] ?? 'text';
            $switch = $field['switch'] ?? false;
            $switch_file = $field['switch_file'] ?? $switch;

            if ($type == 'text') {
                $line[$field['title']] = $field['value'] ?? $entry[$field['name']];
            } elseif ($type == 'find') {

                [$column, $tableAndWhere] = explode(' FROM ', $field['find'][0], 2);
                [$findTable, $where] = preg_split('/\s+WHERE\s+/i', $tableAndWhere, 2);
                $val = DB::table(trim($findTable))
                    ->whereRaw($where, array_values((array) $entry[$field['find'][1]]))
                    ->value(trim($column, '`'));

                if ($switch_file) {
                    $val = empty($val) ? $field['switch_file'][1] : $field['switch_file'][0];
                }
                if (isset($field['parse']) && $field['parse'] == 'int') {
                    $val = (int) $val;
                }

                $line[$field['title']] = $val;
            }
        }

        $array[] = $line;
    }

    $title_file = $title_file ?? $title;

    download_csv($array, str_replace(' ', '_', $title_file).'_'.date('Y-m-d'));
}

// store variables
$this->set('title', $title);
$this->set('back', $back);
$this->set('index', $index);
$this->set('fields', $fields);
$this->set('list', $list);
$this->set('actions', $actions);
$this->set('search_bar', $search_bar);
