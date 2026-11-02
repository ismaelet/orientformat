<?php

namespace App\Http\Controllers\Activities;

use App\Http\Controllers\Controller;
use App\Models\Activities\Area;
use App\Models\Activities\Section;
use App\Services\LegacyPageRenderer;

class StudentAnalysisController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(?Area $area, ?Section $section, LegacyPageRenderer $renderer)
    {
        $type = $area ? 'area' : 'section';

        if ($section->id) {
            $area = $section->area;
        }

        $page = $section->id
            ? $section->originalSection()->slug
            : ($area->id ? 'area-'.$area->slug : null);

        if (! $page) {
            return redirect()->back();
        }

        return $renderer->render(
            page: 'student-read/'.$page,
            template: 'student-read',
            title: 'Saperne di più',
            data: [
                'sectionId' => $section->id,
                'areaId' => $area->id,
                'page' => $page,
                'type' => $type,
            ],
        );
    }
}
