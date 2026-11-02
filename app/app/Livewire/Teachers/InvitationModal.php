<?php

namespace App\Livewire\Teachers;

use App\Models\Class\InviteRequest;
use App\Models\Schools\SchoolClass;
use App\Models\User\Teacher;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Validate;
use Livewire\Component;

class InvitationModal extends Component
{
    /**
     * Property: The ID of the teacher to invite
     */
    #[Validate('required', 'exists:teachers,id')]
    public ?int $invitedTeacherId = null;

    /**
     * Property: Current user's teacher model
     */
    public Teacher $teacher;

    /**
     * Property: The class being managed
     */
    public SchoolClass $class;

    /**
     * Property: Teachers not in the class
     */
    public ?Collection $teachersNotInClass = null;

    /**
     * Lifecycle method: Initialize component
     */
    public function boot()
    {
        $this->teachersNotInClass = $this->teacher->school->teachers()
            ->whereDoesntHave('school_classes', fn ($query) => $query->where('school_classes.id', $this->class->id))
            ->with('user')
            ->get()
            ->sortBy(fn ($t) => $t->user?->last_name);
    }

    /**
     * Lifecycle method: Render the component
     */
    public function render()
    {
        return view('livewire.teachers.invitation-modal');
    }

    /**
     * Action: Send an invitation to a teacher
     */
    public function sendInvitation()
    {
        session()->flash('status', 'Invito mandato a <strong>'.$this->teachersNotInClass->firstWhere('id', $this->invitedTeacherId)?->inverted_full_name.'</strong>. Il/la docente dovrà accettare l\'invito per essere aggiunto/a alla classe.');

        if (InviteRequest::where('invited_teacher_id', $this->invitedTeacherId)
            ->where('class_id', $this->class->id)
            ->exists()
        ) {
            return;
        }

        InviteRequest::create([
            'inviting_teacher_id' => $this->teacher->id,
            'invited_teacher_id' => $this->invitedTeacherId,
            'class_id' => $this->class->id,
        ]);
    }
}
