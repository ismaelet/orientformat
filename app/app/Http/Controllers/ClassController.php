<?php

namespace App\Http\Controllers;

use App\Models\Class\InviteRequest;
use App\Models\Class\JoinRequest;
use App\Models\Schools\Grade;
use App\Models\Schools\SchoolClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClassController extends Controller {

    /**
     * Show the form for creating a new class
     */
    public function create() {
        return view(
            'classes.create',
            ['title' => 'Aggiungi una classe',]
        );
    }

    /**
     * Show the form for creating a new middle school class
     */
    public function createMiddleSchool() {
        $school = teacher()->school;

        return view(
            'classes.create.middleschool',
            ['title' => 'Aggiungi una classe', 'school' => $school]
        );
    }

    /**
     * Show the form for creating a new high school class
     */
    public function createHighSchool() {
        $school = teacher()->school;

        return view(
            'classes.create.highschool',
            ['title' => 'Aggiungi una classe', 'school' => $school]
        );
    }

    /**
     * Show the form for joining an existing class
     */
    public function joinShow() {
        $school = teacher()->school;
        $teacherClasses = teacher()->school_classes;
        $class = session('class');
        $classes = SchoolClass::where('schoolId', $school->id)
            ->where('ended', false)
            ->whereNotIn('id', $teacherClasses->pluck('id'))
            ->orderBy('grade', 'asc')
            ->orderBy('letter', 'asc')
            ->with('referent', 'referent.user')
            ->get()
            ->mapWithKeys(function ($class) {
                return [$class->id => $class->name . ' (' . $class->referent?->full_name . ')'];
            });

        return view(
            'classes.join',
            ['title' => 'Unisciti a una classe', 'school' => $school, 'class' => $class, 'classes' => $classes]
        );
    }

    /**
     * Store a newly created class in storage
     */
    public function store(Request $request): RedirectResponse {
        $request->validate([
            'letter' => 'required|string|max:10',
            'grade' => 'required|integer|in:1,2,3,4,5,6,7,8',
            'schoolId' => 'required|integer|exists:schools,id',
            'professional' => 'nullable|boolean',
        ]);

        $response = SchoolClass::createFromData($request->all());

        if ($response instanceof RedirectResponse) {
            return $response;
        }

        return redirect()->route('teacher.dashboard')->with('success', 'Classe aggiunta con successo.');
    }

    /**
     * Store a newly created class in storage
     */
    public function joinStore(Request $request): RedirectResponse {
        $request->validate([
            'class_id' => 'required|integer|exists:school_classes,id',
        ]);

        $class = SchoolClass::findOrFail($request->input('class_id'));

        if ($class->school != teacher()->school) {
            return back()->withErrors(['class_id' => 'La classe selezionata non appartiene al tuo istituto.'])->withInput();
        }

        if ($class->referent && !JoinRequest::where('class_id', $class->id)
            ->where('requesting_teacher_id', teacher()->id)
            ->exists()) {

            JoinRequest::create([
                'class_id' => $class->id,
                'referent_id' => $class->referent->id,
                'requesting_teacher_id' => teacher()->id,
            ]);
        }

        return redirect()->route('classes.join.show')->with('class', $class);
    }

    /**
     * Accept a join request
     */
    public function joinAccept(Request $request, JoinRequest $joinRequest): RedirectResponse {
        if ($joinRequest->referent_id != teacher()->id) {
            return back()->withErrors(['join_request_id' => 'Non sei autorizzato ad accettare questa richiesta.']);
        }

        if (!$joinRequest->requesting_teacher->school_classes->contains($joinRequest->class_id)) {
            $joinRequest->requesting_teacher->school_classes()->attach($joinRequest->class_id);
        }

        $joinRequest->delete();

        return redirect()->route('teacher.dashboard')->with('success', 'Richiesta accettata con successo.');
    }

    /**
     * Reject a join request
     */
    public function joinReject(Request $request, JoinRequest $joinRequest): RedirectResponse {
        if ($joinRequest->referent_id != teacher()->id) {
            return back()->withErrors(['join_request_id' => 'Non sei autorizzato a rifiutare questa richiesta.']);
        }

        $joinRequest->delete();

        return redirect()->route('teacher.dashboard')->with('success', 'Richiesta rifiutata con successo.');
    }

    /**
     * Accept an invite request
     */
    public function inviteAccept(Request $request, InviteRequest $inviteRequest): RedirectResponse {
        if ($inviteRequest->invited_teacher_id != teacher()->id) {
            return back()->withErrors(['invite_request_id' => 'Non sei autorizzato ad accettare questa richiesta.'])->withInput();
        }

        if (!teacher()->school_classes->where('id', $inviteRequest->class_id)->count()) {
            teacher()->school_classes()->attach($inviteRequest->class_id);
        }

        $inviteRequest->delete();

        return redirect()->route('teacher.dashboard')->with('success', 'Richiesta di invito accettata con successo.');
    }

    /**
     * Reject an invite request
     */
    public function inviteReject(Request $request, InviteRequest $inviteRequest): RedirectResponse {
        if ($inviteRequest->invited_teacher_id != teacher()->id) {
            return back()->withErrors(['invite_request_id' => 'Non sei autorizzato a rifiutare questa richiesta.'])->withInput();
        }

        $inviteRequest->delete();

        return redirect()->route('teacher.dashboard')->with('success', 'Richiesta di invito rifiutata con successo.');
    }
}
