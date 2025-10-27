<?php

namespace App\Http\Controllers\Activities;

use App\Http\Controllers\Controller;
use App\Models\Activities\Area;
use App\Models\Activities\Section;
use Illuminate\Http\Request;

class StudentAnalysisController extends Controller {

    /**
     * Display the specified resource.
     */
    function show(?Area $area, ?Section $section) {
        $type = $area ? 'area' : 'section';

        if ($section->id) {
            $area = $section->area;
        }

        $page = $section->id ? $section->originalSection()->slug : ($area->id ? 'area-' . $area->slug : null);

        if (!$page) {
            return redirect()->back();
        }

        \App\Legacy\LegacyView::setPage('student-read/' . $page)
            ->setTitle('Saperne di più')
            ->setTemplate('student-read')
            ->set('sectionId', $section->id)
            ->set('areaId', $area->id)
            ->set('page', $page)
            ->set('type', $type)
            ->show();
    }
}
